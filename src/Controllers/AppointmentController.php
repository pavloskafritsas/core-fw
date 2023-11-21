<?php

namespace Pk\Core\Controllers;

use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;
use Pk\Core\Helpers\Request;
use Pk\Core\Helpers\Response;
use Pk\Core\Helpers\View;
use Pk\Core\Helpers\Xml;
use Pk\Core\Models\Appointment;
use Pk\Core\Models\User;
use Pk\Core\Models\VaccinationCenter;

class AppointmentController
{
    /**
     * Προβολή σελίδας apppointments με φορτωμένα όλα τα μοντέλα vaccinationCenters
     * 
     * @return void
     */
    public function view()
    {
        View::render('appointments', [
            'vaccinationCenters' => VaccinationCenter::all(['id', 'name']),
        ]);
    }

    /**
     * Προβολή ραντεβού που ανήκουν στο εμβολιαστικό κεντρό του χρήστη-ιατρού
     * 
     * @return void
     */
    public function showUserAppointments()
    {
        $vaccinationCenters = Auth::user()->vaccinationCenters();

        $vaccinationCenterIds = [];

        foreach ($vaccinationCenters as $vaccinationCenter) {
            $vaccinationCenterIds[] = $vaccinationCenter->id;
        }

        $appointmentQ = Appointment::query();

        foreach ($vaccinationCenterIds as $vaccinationCenterId) {
            $appointmentQ->whereEqual('vaccination_center_id', $vaccinationCenterId);
        }

        $appointments = $appointmentQ->orderBy('date_time')->get();

        View::render('view-appointments', ['appointments' => $appointments]);
    }

    /**
     * Ορισμός ενός ραντεβού απο μη ολοκληρωμένο σε ολοκληρωμένο
     * 
     * @return void
     */
    public function complete()
    {
        $appointment = Appointment::find(Request::get('id'));

        if (!$appointment) {
            return Redirect::toUrl('/me/appointments', ['errors' => 'Το ραντεβού δεν βρέθηκε']);
        }

        $vaccinationCenter = $appointment->vaccinationCenter();

        foreach (Auth::user()->vaccinationCenters() as $userCenter) {
            if ($userCenter->id !== $vaccinationCenter->id) {
                return Redirect::toUrl('/me/appointments', ['errors' => 'Το ραντεβού δεν ανήκει στο δικό σας εμβολιαστικό κέντρο']);
            }
        }

        $appointment->complete();

        Redirect::toUrl('/me/appointments');
    }

    /**
     * Ακύρωση ραντεβού ενός χρήστη-πολίτη
     * 
     * @return void
     */
    public function deleteUserAppointment()
    {
        $appointment = Auth::user()->appointment();

        if (!$appointment) {
            Response::json(['errors' => ['To ραντεβού δεν βρέθηκε']], 404);
        }

        $appointment->delete();

        Response::noContent();
    }

    /**
     * Προβολή αρχείου XML.
     * 
     * @return void
     */
    public function viewReport()
    {
        Xml::viewXml(User::REPORT_FILENAME);
    }

    /**
     * Κατέβασμα αρχείου XML.
     * 
     * @return void
     */
    public function downloadReport()
    {
        Xml::downloadXml(User::REPORT_FILENAME);
    }
}
