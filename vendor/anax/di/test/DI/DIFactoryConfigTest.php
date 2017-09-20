<?php

namespace Anax\DI;

/**
 * Testing the Dependency Injector service container.
 */
class DIFactoryConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check the default services created.
     */
    public function testDefaultServices()
    {
        $di = new DIFactoryConfig("di.php");
        $services = $di->getServices();
        $defaultServices = [
            "request",
            "response",
            "url",
            "router",
            "view",
            "viewRenderFile",
            "session",
            "textfilter",
        ];

        foreach ($services as $service) {
            $this->assertContains($service, $defaultServices);
        }
    }



    /**
     * Use set to overwrite a service that was previously created.
     */
    public function testOverwritePreviousDefinedService()
    {
        $di = new DIFactoryConfig("di.php");
        $service = 'session';

        $di->set($service, function () {
            $session = new \stdClass();
            return $session;
        });

        $session = $di->get($service);
        $this->assertInstanceOf('\stdClass', $session);
    }



    /**
     * Add and access a dummy service.
     */
    public function testDummyService()
    {
        $di = new DIFactoryConfigMagic("di.php");

        $di->set("dummy", function () {
            $obj = new DummyService();
            return $obj;
        });

        $obj = $di->get("dummy");
        $this->assertInstanceOf('\Anax\DI\DummyService', $obj);

        $res = $di->get("dummy")->property;
        $this->assertEquals("property", $res);

        $res = $di->get("dummy")->method();
        $this->assertEquals("method", $res);
    }
}
