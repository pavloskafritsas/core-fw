<?php

namespace Pk\Core\InvalidCastTypeException;


/**
 * Προβολή σφάλματος 500 όταν ο τύπος της μεταβλητής στο casts attribute κάποιου μοντέλου(Μodel) δεν είναι σωστός
 */
class InvalidCastTypeException extends \Exception
{
    public function __construct(string $type, ?\Throwable $previous = null)
    {
        parent::__construct("Cast type {$type} is invalid.", 500, $previous);
    }
}
