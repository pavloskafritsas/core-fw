<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\View;

class HasRoleDoctor implements Middleware
{
    /**
     * Έλεγχος εάν ο συνδεδεμένος χρήστης είναι ιατρός
     */
    public function handle()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'doctor') {
            View::render('errors/403', [], 403);

            return false;
        }
    }
}
