<?php

namespace Anax\Common;

/**
 * Testing.
 *
 */
class AppInjectableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testTrait()
    {
        $injectable = new MockAppInjectable();
        $app = new \stdClass();
        $injectable->setApp($app);
    }
}
