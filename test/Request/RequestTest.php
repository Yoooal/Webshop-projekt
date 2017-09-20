<?php

namespace Anax\Request;

/**
 * Test cases for class Guess.
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateObject()
    {
        $request = new Request();
        $this->assertInstanceOf("\Anax\Request\Request", $request);

    }
}
