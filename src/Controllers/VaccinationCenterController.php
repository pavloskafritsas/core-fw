<?php

namespace Pk\Core\Controllers;

use Pk\Core\Helpers\Redirect;
use Pk\Core\Helpers\Request;
use Pk\Core\Helpers\Response;
use Pk\Core\Models\Appointment;
use Pk\Core\Models\VaccinationCenter;

class VaccinationCenterController
{
    /**
     * Λήψη ραντεβού για συγκεκριμένο εμβολιαστικό κέντρο
     * 
     * @return void
     */
    public function getAppointments()
    {
        $vaccinationCenter = VaccinationCenter::find(Request::get('id'));

        if (!$vaccinationCenter) {
            Response::json(['errors' => 'Το εμβολιαστικό κέντρο δεν υπάρχει.'], 404);
        }

        $appointments = $vaccinationCenter->appointments();

        $data = array_map(
            function (Appointment $appointment) {
                return $appointment->toArray();
            },
            $appointments
        );

        Response::json($data);
    }

    /**
     * Εγγραφή ραντεβού στη βάση δεδομένων και συσχέτισή του με το εμβολιαστικό κεντρό και τον συνδεδεμένο χρήστη
     * 
     * @return void
     */
    public function storeAppointment()
    {
        $data = Request::all();

        $vaccinationCenter = VaccinationCenter::find($data['id']);

        if (!$vaccinationCenter) {
            Redirect::back(['Το εμβολιαστικό κέντρο δεν βρέθηκε']);
        }

        unset($data['id']);

        $errors = Appointment::validate($data);

        if ($errors) {
            Redirect::back($errors);
        }

        Appointment::create(
            ['vaccination_center_id' => $vaccinationCenter->id] + $data
        );

        Redirect::toUrl('/me');
    }
}
