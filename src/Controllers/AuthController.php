<?php

namespace Pk\Core\Controllers;

use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Redirect;
use Pk\Core\Helpers\Request;

class AuthController
{
    /**
     * Ταυτοποίηση χρήστη κατά την προσπάθεια εισόδου
     */
    public function login(): void
    {
        if (Auth::attempt(Request::get('amka'), Request::get('afm'))) {
            Redirect::toUrl('/me');
        } else {
            Redirect::back([
                'old' => Request::all(),
                'errors' => ['Τα στοιχεία δεν είναι έγκυρα.'],
            ]);
        }
    }

    /**
     * Για την αποσύνδεση του χρήστη και τερματισμός session
     */
    public function logout(): void
    {
        Auth::logout();

        Redirect::toUrl('/');
    }
}
