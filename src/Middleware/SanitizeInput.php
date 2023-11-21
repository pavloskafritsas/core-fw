<?php

namespace Pk\Core\Middleware;

use Pk\Core\Contracts\Middleware;

class SanitizeInput implements Middleware
{
    /**
     * Αποθήκευση τιμών απο φόρμα html αφαιρώντας πρώτα τους επισφαλής χαρακτήρες και τα php tags 
     */
    public function handle()
    {
        $_SESSION['form_data'] = null;

        foreach ($_POST as $k => $v) {
            $_SESSION['form_data'][$k] = trim(strip_tags(htmlspecialchars($v)));
        }
    }
}
