<?php

namespace Pk\Core\Helpers;

use DateTime;

class Validator
{
    /**
     * Έλεγχος εάν το αλφαριθμητικό είναι αριθμός με χρήση regex
     * 
     * @return string|void
     */
    public static function isNumber(string $field, string $value)
    {
        if (!preg_match('/^\d*$/', $value)) {
            return "Το πεδίο $field πρέπει να αποτελείται μόνο από αριθμούς.";
        }
    }

    /**
     * Έλεγχος εάν το αλφαριθμητικό είναι μεταξύ ορισμένων τιμών
     * 
     * @return string|void
     */
    public static function stringLengthBetween(string $field, string $value, int $min, int $max)
    {
        if (strlen($value) < $min || strlen($value) > $max) {
            return "Το πεδίο $field πρέπει να αποτελείται από $min έως $max χαρακτήρες.";
        }
    }

    /**
     * Έλεγχος εάν το αλφαριθμητικό αποτελείται απο συγκεκριμένους χαρακτήρες
     * 
     * @return string|void
     */
    public static function stringLengthIs(string $field, string $value, int $length)
    {
        if (strlen($value) !== $length) {
            return "Το πεδίο $field πρέπει να αποτελείται από $length χαρακτήρες.";
        }
    }

    /**
     * Έλεγχος εάν το αλφαριθμητικό είναι διεύθυνση email
     * 
     * @return string|void
     */
    public static function email(string $field, string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "Το πεδίο $field πρέπει να είναι έγκυρη διεύθυνση email.";
        }
    }

    /**
     * Έλεγχος εάν το αλφαριθμητικό είναι ημερομηνία
     * 
     * @return string|void
     */
    public static function date(string $field, string $value, string $format)
    {
        if (!DateTime::createFromFormat($format, $value)) {
            return "Το πεδίο $field πρέπει να έχει μορφή $format.";
        }
    }

    /**
     * Έλεγχος εάν το αλφαριθμητικό πληρεί τις προυποθέσεις του regex
     * 
     * @return string|void
     */
    public static function regex(string $regex, string $value, string $errorMsg)
    {
        if (!preg_match($regex, $value)) {
            return $errorMsg;
        }
    }

    /**
     * Έλεγχος εάν το αλφαριθμητικό ανήκει σε συγκεκριμένες τιμές
     * 
     * @return string|void
     */
    public static function inArray(string $field, string $needle, array $haystack)
    {
        if (!in_array($needle, $haystack, true)) {
            return "Το πεδίο $field μπορεί να περιέχει μία από αυτές τις τιμές: " . implode(',', $haystack);
        }
    }

    /**
     * Έλεγχος μοναδικότητας στη ΒΔ
     * 
     * @return string|void
     */
    public static function unique(string $field, string $value, string $table, string $column)
    {
        $exists = (new QueryBuilder($table))->select([$column])->whereEqual($column, $value)->count() > 0;

        if ($exists) {
            return "Το $field: $value υπάρχει ήδη στο σύστημα.";
        }
    }
}
