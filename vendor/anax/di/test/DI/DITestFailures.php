<?php

namespace Anax\DI;

use Anax\DI\Exception\Exception;
use Anax\DI\Exception\NotFoundException;

/**
 * Testing the Dependency Injector service container.
 */
class DITestFailures extends \PHPUnit_Framework_TestCase
{
    /**
     * A user can not throw a custom exception in the callback initiating
     * the service. It will result in a DIException
     *
     * @expectedException Exception
     */
    public function testLoadFailesInServiceCreationWithCustomException()
    {
        $di = new DI();
        $service = 'failsWithException';

        $di->set($service, function () {
            throw new \Exception("Failed creating service.");
        });

        $di->get($service);
    }



    /**
     * Using unknown classname as a string to load the service.
     *
     * @expectedException Exception
     */
    public function testLoadFailesInServiceCreationWithUnknownClassname()
    {
        $di = new DI();
        $service = 'failsWithException';

        $di->set($service, "NO_EXISTING_CLASS");

        $di->get($service);
    }
}
