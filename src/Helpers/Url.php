<?php

namespace Pk\Core\Helpers;

class Url
{
    private const ASSETS_URL = '/assets/';

    /**
     * φόρτωση αρχείου απο το φάκελο assets
     * 
     * @return string
     */
    public static function asset(string $file)
    {
        return self::ASSETS_URL . $file;
    }
}
