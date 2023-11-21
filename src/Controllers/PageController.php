<?php

namespace Pk\Core\Controllers;

use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;
use Pk\Core\Helpers\Request;
use Pk\Core\Helpers\View;
use Pk\Core\Models\Appointment;
use Pk\Core\Models\VaccinationCenter;

class PageController
{
    /**
     * Φόρτωση σελίδας index
     * 
     * @return void
     */
    public function index()
    {
        View::render('index');
    }

    /**
     * Φόρτωση σελίδας login
     * 
     * @return void
     */
    public function login()
    {
        View::render('login');
    }

    /**
     * Φόρτωση αρχικής σελίδας χρήστη
     * 
     * @return void
     */
    public function me()
    {
        $vaccinationCenter = null;

        $user = Auth::user();

        if ($user->role === 'doctor') {
            $vaccinationCenter = $user->vaccinationCenters()[0] ?? null;
        }

        View::render('me', compact('vaccinationCenter', 'user'));
    }

    /**
     * Φόρτωση σελίδας εμβολιαστικών κέντρων
     * 
     * @return void
     */
    public function vacCenters()
    {
        View::render('vac_centers');
    }

    /**
     * Φόρτωση σελίδας οδηγιών εμβολιασμού
     * 
     * @return void
     */
    public function vacGuide()
    {
        View::render('vac_guide');
    }

    /**
     * Φόρτωση σελίδας οδηγιών εγγραφής στην πλατφόρας
     * 
     * @return void
     */
    public function signin()
    {
        View::render('signin');
    }

    /**
     * Φόρτωση σελίδας ανακοινώσεων
     * 
     * @return void
     */
    public function anakoinoseis()
    {
        View::render('anakoinoseis');
    }

    /**
     * Φόρτωση σελίδας συγκεκριμένης ανακοίνωσης 1, 2, 3
     * 
     * @return void
     */
    public function viewAnakoinosi()
    {
        $anakoinosiIds = [1, 2, 3];

        $id = (int) Request::get('id');

        if (!in_array($id, $anakoinosiIds, true)) {
            Redirect::toUrl('/anakoinoseis');
        } else {
            View::render("anakoinosi_{$id}");
        }
    }

    /**
     * Φόρτωση σελίδας επιλογής εμβολιαστικού κέντρου για χρήστη-ιατρό
     * 
     * @return void
     */
    public function selectVaccinationCenter()
    {
        View::render('select-vaccination-center', ['vaccinationCenters' => VaccinationCenter::all()]);
    }

    /**
     * Φόρτωση σελίδας εγγραφής χρήστη
     * 
     * @return void
     */
    public function register()
    {
        View::render('register');
    }

    /**
     * Φόρτωση σελίδας σταττιστικών ραντεβού που ανήκουν στο επιλεγμένο εμβολιαστικό κέντρο.
     * 
     * @return void
     */
    public function report()
    {
        $vaccinationCenter = Auth::user()->vaccinationCenters()[0];

        $appointments = Appointment::whereEqual('vaccination_center_id', $vaccinationCenter->id)->orderBy('date_time')->get();

        $appointmentsCount = count($appointments);

        $completedAppointments =
            Appointment::whereEqual('status', 'Ολοκληρωμένο')
            ->whereEqual('vaccination_center_id', $vaccinationCenter->id)
            ->count();

        $completionPercentage =  number_format($completedAppointments / $appointmentsCount * 100, 2);

        Auth::user()->makeReport();

        View::render('report', compact([
            'appointments',
            'appointmentsCount',
            'completionPercentage',
        ]));
    }
}
