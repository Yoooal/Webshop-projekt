<?php

namespace Anax\DI;

/**
 * Trait to use for DI aware services to let them know of the current $di.
 *
 */
trait InjectionAwareTrait
{
    /**
     * @var Anax\DI\DIInterface $di the DI service container.
     */
    protected $di;



    /**
     * Set the service container to use
     *
     * @param Anax\DI\DIInterface $di a service container
     *
     * @return self
     */
    public function setDI(DIInterface $di)
    {
        $this->di = $di;
        return $this;
    }
}
