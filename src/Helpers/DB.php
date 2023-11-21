<?php

namespace Pk\Core\Helpers;

use PDO;


/**
 * Διεπαφή με τη βάση δεδομένων χρησιμοποιώντας το PDO extension
 */
class DB extends PDO
{
    private string $host;

    private string $database;

    private string $username;

    private string $password;

    private static ?self $instance = null;

    public function __construct()
    {
        $this->host     = Env::get('DB_HOST');
        $this->database = Env::get('DB_DATABASE');
        $this->username = Env::get('DB_USERNAME');
        $this->password = Env::get('DB_PASSWORD');

        parent::__construct(
            $this->getDsn(),
            $this->username,
            $this->password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    /**
     * κατασκευή string του Dsn
     */
    private function getDsn(): string
    {
        return "mysql:host={$this->host};dbname={$this->database}";
    }

    /**
     * Επιστροφή δημιουργημένου μοντέλου ή δημιουργία νέου σε περίπτωση που δεν υπάρχει ήδη
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
