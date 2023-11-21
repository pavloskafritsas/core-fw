<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;

class UserCanCreateAppointment implements Middleware
{
    /**
     * Έλεγχος ο χρήστης μπορεί να κλείσει ραντεβού
     * 
     * @return void|false
     */
    public function handle()
    {
        if (!Auth::user()->canScheduleAppointment()) {
            Redirect::toUrl('/me');

            return false;
        }
    }
}
