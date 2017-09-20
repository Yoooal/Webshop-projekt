<?php

namespace Anax\DI;

use Anax\DI\DIInterface;

/**
 * Interface to implement for DI aware services to let them know of the
 * current $di
 */
interface InjectionAwareInterface
{
    /**
     * Set the service container to use
     *
     * @param Anax\DI\DIInterface $di a service container
     *
     * @return $this
     */
    public function setDI(DIInterface $di);
}
