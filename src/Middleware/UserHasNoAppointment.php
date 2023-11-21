<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;
use Pk\Core\Helpers\Auth;

class UserHasNoAppointment implements Middleware
{
    /**
     * Έλεγχος εάν ο χρήστης έχει ραντεβού.
     * 
     * @return void|false
     */
    public function handle()
    {
        if (Auth::user()->appointment()) {
            return false;
        }
    }
}
