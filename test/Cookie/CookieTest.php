<?php

namespace joel\Cookie;

/**
 * Test cases for class Guess.
 */
class CookieTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateObject()
    {
        $cookie = new Cookie();
        $this->assertInstanceOf("\joel\Cookie\Cookie", $cookie);

    }
}
