<?php

namespace Anax\DI;

/**
 * Testing the Dependency Injector service container.
 */
class DITest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create a service instantiating using a callback.
     */
    public function testSetUsingCallback()
    {
        $di = new DI();
        $service = 'someService';

        $di->set($service, function () {
            return new \stdClass();
        });

        $someService = $di->get($service);
        $this->assertInstanceOf('\stdClass', $someService);
    }



    /**
     * Create a service instantiating using a string.
     */
    public function testSetUsingString()
    {
        $di = new DI();
        $service = 'someService';

        $di->set($service, "\stdClass");

        $someService = $di->get($service);
        $this->assertInstanceOf('\stdClass', $someService);
    }



    /**
     * Create a service instantiating using a prepared object.
     */
    public function testSetUsingObject()
    {
        $di = new DI();
        $service = 'someService';
        $object = new \stdClass();

        $di->set($service, $object);

        $someService = $di->get($service);
        $this->assertInstanceOf('\stdClass', $someService);
    }
}
