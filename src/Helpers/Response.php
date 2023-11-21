<?php

namespace Pk\Core\Helpers;

class Response
{
    /**
     * Επιστροφή απάντησης τύπου json στον client (browser) με δεδομένα που του έχουν παρασχεθεί
     * 
     * @param mixed $data
     * @param int $code
     */
    public static function json($data, $code = 200)
    {
        header('Content-Type: application/json');

        http_response_code($code);

        echo json_encode($data);
    }

    /**
     * Επιστροφή απάντησης no Content (http status 204)
     */
    public static function noContent()
    {
        http_response_code(204);
    }
}
