<?php

namespace Pk\Core\Helpers;

use Pk\Core\Contracts\Middleware;

class Route
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $uri;

    /**
     * @var array<string>
     */
    private array $action;

    /**
     * @var array<Middleware|null>
     */
    private ?array $middlewares;

    /**
     * @var array<string|null>
     */
    private array $uriParams = [];

    public function __construct(string $method, string $uri, array $action, ?array $middlewares = null)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
        $this->middlewares = $middlewares;
    }

    /**
     * λήψη αριθμού παραμέτρων που υπάρχουν εντός του uri
     * 
     * @return int|false|null
     */
    private function getUriParamCount()
    {
        return preg_match_all('/\{(\w+)\}/', $this->uri);
    }

    /**
     * Έλεγχος ύπαρξης παραμέτρων εντός του uri
     * 
     * @param string $uriToken
     * 
     * @return int|false
     */
    private function uriHasParams($uriToken)
    {
        return preg_match('/\{(\w+)\}/', $uriToken);
    }

    /**
     * Έλεγχος αν το ζητούμενο uri ταυτίζεται με το συγκεκριμένο route ($this)
     * 
     * @return bool
     */
    public function matches(): bool
    {
        if ($this->method !== $_SERVER['REQUEST_METHOD']) {
            return false;
        }

        if (($requestUri = $_SERVER['REQUEST_URI']) === $this->uri) {
            return true;
        }

        // check if route uri has parameters
        if ($this->getUriParamCount() < 1) {
            return false;
        }

        // route uri has parameters

        $uriTokens = explode('/', $this->uri);
        $requestUriToken = explode('/', $requestUri);

        for ($i = 0; $i < count($uriTokens); $i++) {
            if ($this->uriHasParams($uriTokens[$i])) {
                if (!isset($requestUriToken[$i])) {
                    return false;
                }

                $this->setUriParam($uriTokens[$i], $requestUriToken[$i]);
            } else {
                if ($uriTokens[$i] !== $requestUriToken[$i]) {
                    return false;
                }
            }
        }

        $this->storeUriParams();

        return true;
    }

    /**
     * Αποθήκευση παραμέτρου uri
     * 
     * @param string $uriToken
     * @param string $uriValue
     * 
     * @return void
     */
    private function setUriParam($uriToken, $uriValue)
    {
        $this->uriParams[$this->getUriParamName($uriToken)] = $uriValue;
    }

    /**
     * Αποθήκευση όλων των παραμέτρων uri στο session του χρήστη
     * 
     * @return void
     */
    private function storeUriParams()
    {
        $_SESSION['uri_params'] = $this->uriParams;
    }

    /**
     * Λήψη ονόματος παραμέτρου uri
     * 
     * @param string $uriToken
     * 
     * @return string
     */
    private function getUriParamName($uriToken)
    {
        return preg_replace('/{|}/', '', $uriToken);
    }

    /**
     * Εκτέλεση Middleware του route (εάν υπάρχουν)
     * Αν κάποιο Middleware επιστρέψει false τερματίζει
     * αλλιώς εκτελείτε το δηλωμένο action μορφής ([όνομα_κλάσης, όνομα_συνάρτησης])
     */
    public function handle(): void
    {
        if ($this->middlewares) {
            foreach ($this->middlewares as $middleware) {
                if ((new $middleware)->handle() === false) {
                    return;
                }
            }
        }

        (new $this->action[0])->{$this->action[1]}();
    }

    /**
     * Δημιουργία νέου route object με μέθοδο delete
     */
    public static function delete(string $uri, array $action, ?array $middlewares = null): self
    {
        return new self('DELETE', $uri, $action, $middlewares);
    }

    /**
     * Δημιουργία νέου route object με μέθοδο get
     */
    public static function get(string $uri, array $action, ?array $middlewares = null): self
    {
        return new self('GET', $uri, $action, $middlewares);
    }

    /**
     * Δημιουργία νέου route object με μέθοδο post
     */
    public static function post(string $uri, array $action, ?array $middlewares = null): self
    {
        return new self('POST', $uri, $action, $middlewares);
    }

    /**
     * Δημιουργία νέου route object με μέθοδο patch
     */
    public static function patch(string $uri, array $action, ?array $middlewares = null): self
    {
        return new self('PATCH', $uri, $action, $middlewares);
    }
}
