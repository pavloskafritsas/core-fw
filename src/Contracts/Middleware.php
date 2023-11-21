<?php

namespace Pk\Core\Contracts;

/**
 * Όταν μία κλάση πρέπει να κάνει implement το πρότυπο Middleware
 * υποχρεώτικά θα περιέχει μια συνάρτηση handle.
 */
interface Middleware
{
    /**
     * @return false|void
     */
    public function handle();
}
