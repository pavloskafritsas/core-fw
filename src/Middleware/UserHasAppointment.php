<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;

class UserHasAppointment implements Middleware
{
    /**
     * Έλεγχος εάν ο χρήστης μπορεί να δει στοιχεία ραντεβού
     * 
     * @return void|false
     */
    public function handle()
    {
        if (!Auth::user()->appointment()) {
            Redirect::toUrl('/me');

            return false;
        }
    }
}
