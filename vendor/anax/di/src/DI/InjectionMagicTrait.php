<?php

namespace Anax\DI;

use Anax\DI\Exception\Exception;

/**
 * Trait to use for DI aware services to let them know of the current $di.
 */
trait InjectionMagicTrait
{
    /**
     * Magic method to get and create services.
     * When created it is also stored as a parameter of this object.
     *
     * @param string $service name of class property not existing.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     *
     * @return object as the service requested.
     */
    public function __get($service)
    {
        return $this->find($service);
    }



   /**
     * Magic method to get and create services as a method call.
     * When created it is also stored as a parameter of this object.
     *
     * @param string $service   name of class property not existing.
     * @param array  $arguments Additional arguments to sen to the method
     *                          (NOT IMPLEMENTED).
     *
     * @throws NotFoundException  No entry was found for this identifier.
     *
     * @return class as the service requested.
     */
    public function __call($service, $arguments = [])
    {
        return $this->find($service);
    }



    /**
     * Find, load service and set as part of the class, then return it.
     *
     * @param string $service name of class property not existing.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     *
     * @return object as the service requested.
     */
    private function find($service)
    {
        if (!$this->di) {
            throw new Exception("InjectionMagicTrait \$di is not set. Call setDI()?");
        }

        $this->$service = $this->di->get($service);
        return $this->$service;
    }
}
