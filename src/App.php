<?php

namespace Pk\Core;

use Pk\Core\Helpers\QueryBuilder;
use Pk\Core\Helpers\Route;
use Pk\Core\Helpers\View;

class App
{
    /**
     * @var array<Route> 
     */
    private array $routes = [];

    public function __construct()
    {
        $this
            ->setErrorHandler()
            ->startSession()
            ->loadRoutes()
            ->matchRequest()
            ->terminateApplication();
    }

    /**
     * Αντιμετώπιση E_NOTICE και E_WARNING ως exceptions
     */
    public function setErrorHandler()
    {
        set_error_handler(function ($errNo, $errStr, $errFile, $errLine) {
            $msg = "$errStr in $errFile on line $errLine";
            if ($errNo == E_NOTICE || $errNo == E_WARNING) {
                throw new \ErrorException($msg, $errNo);
            } else {
                echo $msg;
            }
        });

        return $this;
    }

    /**
     * εισαγωγή δηλωμένων routes της εφαρμογής απο το αρχείο routes.php
     */
    public function loadRoutes(): self
    {
        $this->routes = include __DIR__ . './../routes.php';

        return $this;
    }

    /**
     * Αντιστοίχιση εισερχόμενου αιτήματος http με το σωστό route
     */
    public function matchRequest(): self
    {
        foreach ($this->routes as $route) {
            if ($route->matches()) {
                try {
                    $route->handle();
                } catch (\Throwable $t) {
                    View::render('errors/500', ['exception' => $t], 500);
                }

                $_SESSION['prev_url'] = $_SERVER['REQUEST_URI'];

                return $this;
            }
        }

        View::render('errors/404', [], 404);

        return $this;
    }

    /**
     * Διαγραφή δεδομένων απο το session
     * 
     * @return self
     */
    private function clearSessionData()
    {
        $_SESSION['uri_params'] = [];

        if ($_SESSION['keep_flashed_data'] ?? false) {
            $_SESSION['keep_flashed_data'] = false;
        } else {
            $_SESSION['flash_data'] = null;
        }

        return $this;
    }

    /**
     * Έναρξη session
     * 
     * @return self
     */
    public function startSession()
    {
        session_start();

        return $this->clearSessionData();
    }

    /**
     * Τερματισμός εφαρμογής κλείνοντας τη ΒΔ 
     */
    public function terminateApplication()
    {
        QueryBuilder::closeDbConnection();

        exit(0);
    }
}
