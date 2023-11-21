<?php

namespace Pk\Core\Helpers;


/**
 * Φόρτωση ρυθμίσεων απο το αρχείο .env
 */
class Env
{
    private const ENV_PATH = __DIR__ . '/../../.env';

    private ?array $values = null;

    private static ?Env $instance = null;

    public function __construct()
    {
        $this->parseEnvFile();
    }

    /**
     * Άνοιγμα αρχείου και διαπέρασή του για διαχωρισμό κλειδιών με τις τιμές τους
     * 
     * @return void
     */
    private function parseEnvFile()
    {
        $file = fopen(self::ENV_PATH, "r");

        while (!feof($file)) {
            $kv = explode('=', fgets($file), 2);

            if (count($kv) === 2 && $kv[0]) {
                $this->values[trim($kv[0])] = trim($kv[1]) ?? null;
            }
        }

        fclose($file);
    }

    /**
     * Επιστροφή δημιουργημένου μοντέλου ή δημιουργία νέου σε περίπτωση που δεν υπάρχει ήδη
     * 
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Επιστροφή τιμής για το ζητούμενο κλειδί (φορτωμένο απο το αρχείο .env)
     * 
     * @return null|string
     */
    public static function get(?string $key = null)
    {
        $env = self::getInstance();

        return $key ? $env->values[$key] : $env->values;
    }
}
