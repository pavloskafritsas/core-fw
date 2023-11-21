<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;

class Guest implements Middleware
{
    /**
     * Έλεγχος εάν ο επισκέπτης είναι συνδεδεμένος ή οχι
     */
    public function handle()
    {
        if (Auth::check()) {
            Redirect::toUrl('/me');

            return false;
        }
    }
}
