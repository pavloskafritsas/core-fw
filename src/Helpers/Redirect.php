<?php

namespace Pk\Core\Helpers;

class Redirect
{
    /**
     * Αποθήκευση δεδομένων για προβολη μέσα σε σελίδα html
     * 
     * @var mixed $data
     */
    private static function flashData($data)
    {
        $_SESSION['flash_data'] = $data;

        $_SESSION['keep_flashed_data'] = true;
    }

    /**
     * Ανακατεύθυνση του χρήστη στην προηγούμενη σελίδα  
     * 
     * @param mixed $data
     * 
     * @return void
     */
    public static function back($data = null)
    {
        self::toUrl($_SESSION['prev_url'], $data);
    }

    /**
     * Ανακατεύθυνση του χρήστη σε συγκεκριμένη σελίδα
     * 
     * @param string $url
     * @param mixed $data
     * 
     * @return void
     */
    public static function toUrl($url, $data = null)
    {
        self::flashData($data);

        header("Location: $url", true);
    }
}
