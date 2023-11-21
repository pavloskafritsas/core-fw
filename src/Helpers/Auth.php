<?php

namespace Pk\Core\Helpers;

use Pk\Core\Models\User;

class Auth
{
    /**
     * Προσπάθεια τυτοποίησης χρήστη από τη βάση δεδομένων
     * 
     * @param null|string $username
     * @param null|string $password
     * 
     * @return bool
     */
    public static function attempt($username, $password)
    {
        $user = User::whereEqual('amka', $username)
            ->whereEqual('afm', $password)
            ->first();

        if ($user) {
            self::loginAs($user);

            return true;
        }

        return false;
    }

    /**
     * Επιστροφή συνδεδεμένου χρήστη
     * 
     * @return null|User
     */
    public static function user()
    {
        $user = $_SESSION['user'] ?? null;

        if ($user) {
            return User::find($user->id);
        }

        return null;
    }

    /**
     * Επιστροφή id συνδεδεμένου χρήστη
     * 
     * @return null|int
     */
    public static function id()
    {
        return self::user()->getKey();
    }

    /**
     * Έλεγχος εάν ο χρήστης είναι ταυτοποιημένος
     * 
     * @return bool
     */
    public static function check(): bool
    {
        return self::user() ? true : false;
    }

    /**
     * Σύνδεση χρήστη
     * 
     * @return void
     */
    public static function loginAs(User $user): void
    {
        $_SESSION['user'] = $user;
    }

    /**
     * Αποσύνδεση συνδεδεμένου χρήστη
     * 
     * @return void
     */
    public static function logout(): void
    {
        unset($_SESSION['user']);
    }
}
