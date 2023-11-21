<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;

class RequiresLogin implements Middleware
{
    /**
     * Έλεγχος ταυτοποίησης χρήστη
     */
    public function handle()
    {
        if (!Auth::check()) {
            Redirect::toUrl('/login');

            return false;
        }
    }
}
