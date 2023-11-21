<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;

class UserHasVaccinationCenter implements Middleware
{

    /**
     * Έλεγχος εάν ο χρήστης έχει επιλέξει εμβολιαστικό κέντρο
     */
    public function handle()
    {
        if (!Auth::user()->vaccinationCenters()) {
            Redirect::back(['errors' => ['Δεν έχετε επιλέξει εξεταστικό κέντρο.']]);

            return false;
        }
    }
}
