<?php

namespace Anax\Response;

/**
 * Test response module.
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Try setting various status codes.
     */
    public function testStatusCodes()
    {
        $resp = new Response();
        $resp->setStatusCode(200);
        $resp->setStatusCode(400);
        $resp->setStatusCode(403);
        $resp->setStatusCode(404);
        $resp->setStatusCode(405);
        $resp->setStatusCode(418);
        $resp->setStatusCode(500);
        $resp->setStatusCode(501);
    }



    /**
     * Test.
     */
    public function testBody()
    {
        $resp = new Response();
        $exp = "body";
        $resp->setBody($exp);
        $res = $resp->getBody();
        $this->assertEquals($exp, $res);
    }
}
