<?php

namespace Pk\Core\Helpers;

class Request
{
    /**
     * Λήψη όλων των υποβεβελημένων δεδομένων απο φόρμες καταχώρησης και απο παραμέτρους μέσα σε url
     * 
     * @return array<null|mixed>
     */
    public static function all()
    {
        return ($_SESSION['uri_params'] ?? []) + ($_SESSION['form_data'] ?? []);
    }

    /**
     * Λήψη τιμής συγκεκριμένου κλειδιου ή επιστροφή null εάν δεν υπάρχει το κλειδί
     * 
     * @param string $key
     * 
     * @return null|mixed
     */
    public static function get($key)
    {
        return static::all()[$key] ?? null;
    }
}
