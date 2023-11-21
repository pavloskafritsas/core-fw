<?php

namespace Pk\Core\Controllers;

use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;
use Pk\Core\Helpers\Request;
use Pk\Core\Helpers\Response;
use Pk\Core\Models\User;
use Pk\Core\Models\VaccinationCenter;

class UserController
{
    /**
     * Έλεγχος για το εάν ο συνδεδεμένος χρήστης-πολίτης έχει δικαίωμα να κλείσει ραντεβού
     * 
     * @return void
     */
    public function canScheduleAppointment()
    {
        Response::json(
            ['can_schedule_appointment' => Auth::user()->canScheduleAppointment()]
        );
    }

    /**
     * Έλεγχος για το εάν ο συνδεδεμένος χρήστης-ιατρός έχει δικαίωμα να επιλέξει εμβολιαστικό κέντρο
     * 
     * @return void
     */
    public function canSelectVaccinationCenter()
    {
        Response::json(
            ['can_select_vaccination_center' => Auth::user()->canSelectVaccinationCenter()]
        );
    }

    /**
     * Συσχέτιση χρήστη-ιατρό με εμβολιαστικό κέντρο
     */
    public function assignUserToVaccinationCenter()
    {
        $user = Auth::user();

        if (!$user->canSelectVaccinationCenter()) {
            Redirect::toUrl('/me');
            return;
        }

        $vaccinationCenter = VaccinationCenter::find(Request::get('vaccination_center_id') ?? -1);

        if (!$vaccinationCenter) {
            Redirect::back(['errors' => ['Το εμβολιαστικό κέντρο δεν βρέθηκε']]);
            return;
        }

        $vaccinationCenter->attachUser($user);

        Redirect::toUrl('/me');
    }

    /**
     * Εγγραφή χρήστη στη βάση δεδομένων
     * 
     * @return void
     */
    public function store()
    {
        $data = Request::all();

        if (isset($data['email']) && empty($data['email'])) {
            unset($data['email']);
        }

        if (isset($data['gender']) && empty($data['gender'])) {
            unset($data['gender']);
        }

        $errors = User::validate($data);

        if ($errors) {
            Redirect::back([
                'old' => $data,
                'errors' => $errors
            ]);
        } else {
            $user = User::create($data);

            Auth::loginAs($user);

            Redirect::toUrl('/me');
        }
    }
}
