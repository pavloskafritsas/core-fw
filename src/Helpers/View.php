<?php

namespace Pk\Core\Helpers;

class View
{
    private const VIEWS_DIR = __DIR__ . './../../views/';

    /**
     * @param ?string $key
     * 
     * @return ?array
     */
    public static function errors($key = null)
    {
        $errors = $_SESSION['flash_data']['errors'] ?? [];

        return $errors[$key] ?? $errors;
    }

    /**
     * Καταγραφή προηγούμενης υποβεβλημένης τιμής από πεδίο html φόρμας
     * 
     * @param ?string $key
     * 
     * @return array|mixed
     */
    public static function old($key = null)
    {
        $old = $_SESSION['flash_data']['old'] ?? [];

        return $key ? ($old[$key] ?? null) : ($old ?? null);
    }

    /**
     * Προβολή template στον client
     */
    public static function render(string $file, array $parameters = [], int $code = 200)
    {
        http_response_code($code);

        ob_start();

        extract($parameters);

        include(self::VIEWS_DIR . $file . '.php');

        echo ob_get_clean();
    }
}
