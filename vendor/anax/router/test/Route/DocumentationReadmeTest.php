<?php

namespace Anax\Route;

/**
 * Testcases.
 */
class DocumentationReadmeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Add some routes with handlers
     */
    public function testAddSomeRoutesWIthHandles()
    {
        $router = new RouterInjectable();

        $router->add("", function () {
            echo "home ";
        });

        $router->add("about", function () {
            echo "about ";
        });

        $router->add("about/me", function () {
            echo "about/me ";
        });

        ob_start();
        // try it out
        $router->handle("");
        $router->handle("about");
        $router->handle("about/me");
        // home about about/me
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "home about about/me ");
    }



    /**
     * Test Add multiple routes with one handler
     */
    public function testAddMultipleRoutesWithOneHandler()
    {
        $router = new RouterInjectable();

        $router->add(["info", "about"], function () {
            echo "info or about - ";
        });

        ob_start();
        // try it out
        $router->handle("info");
        $router->handle("about");
        // info or about - info or about -
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "info or about - info or about - ");
    }



    /**
     * Test Add a default route
     */
    public function testAddDefaultRoute()
    {
        $router = new RouterInjectable();

        $router->always(function () {
            echo "always ";
        });

        ob_start();
        // try it out using some paths
        $router->handle("info");
        $router->handle("about");
        // always always
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "always always ");
    }



    /**
     * Test Add internal routes for 404, 403 and 500 error handling
     */
    public function testAddInternalRoutesForErrorHandling()
    {
        $router = new RouterInjectable();

        $router->addInternal("404", function () {
            echo "404 ";
        });

        $router->add("about", function () {
            echo "about ";
        });

        ob_start();
        // try it out using some paths
        $router->handle("whatever");
        // 404
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "404 ");
    }



    /**
     * Test Add internal routes for 404, 403 and 500 error handling
     */
    public function testAddInternalRoute403()
    {
        $router = new RouterInjectable();

        $router->addInternal("403", function () {
            echo "403 ";
        });

        $router->add("login", function () {
            throw new ForbiddenException();
        });

        ob_start();
        // try it out using some paths
        $router->handle("login");
        // 403
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "403 ");
    }



    /**
     * Test Add internal routes for 404, 403 and 500 error handling
     */
    public function testAddInternalRoute500()
    {
        $router = new RouterInjectable();

        $router->addInternal("500", function () {
            echo "500 ";
        });

        $router->add("calculate", function () {
            throw new InternalErrorException();
        });

        ob_start();
        // try it out using some paths
        $router->handle("calculate");
        // 500
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "500 ");
    }



    /**
     * Test Add a common route for any item below subpath using *
     */
    public function testAddCommonRouteForSubPathOneStar()
    {
        $router = new RouterInjectable();

        $router->add("about/**", function () {
            echo "about ";
        });

        ob_start();
        // try it out using some paths
        $router->handle("about");
        $router->handle("about/me");
        $router->handle("about/you");
        $router->handle("about/some/other");
        // about about about about
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "about about about about ");
    }



    /**
     * Test Add a common route for any item below subpath using **
     */
    public function testAddCommonRouteForSubPathDoubleStar()
    {
        $router = new RouterInjectable();

        $router->addInternal("404", function () {
            echo "404 ";
        });

        $router->add("about/{arg}", function ($arg) {
            echo "$arg ";
        });

        ob_start();
        // try it out using some paths
        $router->handle("about");            // not matched
        $router->handle("about/me");
        $router->handle("about/you");
        $router->handle("about/some/other"); // not matched
        // 404 me you 404
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "404 me you 404 ");
    }



    /**
     * Test Part of path as arguments to the route handler
     */
    public function testRouteWithArguments()
    {
        $router = new RouterInjectable();

        $router->addInternal("404", function () {
            echo "404 ";
        });

        $router->add("about/{arg}", function ($arg) {
            echo "$arg ";
        });

        ob_start();
        // try it out using some paths
        $router->handle("about");            // not matched
        $router->handle("about/me");
        $router->handle("about/you");
        $router->handle("about/some/other"); // not matched
        // 404 me you 404
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "404 me you 404 ");
    }



    /**
     * Test Part of path as arguments to the route handler
     */
    public function testRouteWithMultipleArguments()
    {
        $router = new RouterInjectable();

        $router->add(
            "post/{year}/{month}/{day}",
            function ($year, $month, $day) {
                echo "$year-$month-$day, ";
            }
        );

        ob_start();
        // try it out using some paths
        $router->handle("post/2017/03/07");
        $router->handle("post/1990/06/20");
        // 2017-03-07, 1990-06-20,
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "2017-03-07, 1990-06-20, ");
    }



    /**
     * Test Type checking of arguments
     */
    public function testTypeCheckingOfArguments()
    {
        $router = new RouterInjectable();

        $router->addInternal("404", function () {
            echo "404, ";
        });

        $router->add(
            "post/{year:digit}/{month:digit}/{day:digit}",
            function ($year, $month, $day) {
                echo "$year-$month-$day, ";
            }
        );

        $router->add(
            "post/{year:digit}/{month:alpha}/{day:digit}",
            function ($year, $month, $day) {
                echo "$day $month $year, ";
            }
        );

        ob_start();
        // try it out using some paths
        $router->handle("post/2017/03/seven");
        $router->handle("post/2017/03/07");
        $router->handle("post/1990/06/20");
        $router->handle("post/1990/june/20");
        // 404, 2017-03-07, 1990-06-20, 20 june 1990,
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "404, 2017-3-7, 1990-6-20, 20 june 1990, ");
    }



    /**
     * Test Routes per request method
     */
    public function testRoutePerRequestMethod()
    {
        $router = new RouterInjectable();

        $router->any(["GET"], "about", function () {
            echo "GET ";
        });

        $router->any(["POST"], "about", function () {
            echo "POST ";
        });

        $router->any(["PUT"], "about", function () {
            echo "PUT ";
        });

        $router->any(["DELETE"], "about", function () {
            echo "DELETE ";
        });

        ob_start();
        // try it out using some paths
        $router->handle("about", "GET");
        $router->handle("about", "POST");
        $router->handle("about", "PUT");
        $router->handle("about", "DELETE");
        // GET POST PUT DELETE
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "GET POST PUT DELETE ");
    }



    /**
     * Test Routes per request method
     */
    public function testRoutePerMultipleRequestMethod()
    {
        $router = new RouterInjectable();

        $router->any(["GET", "POST"], "about", function () {
            echo "GET+POST ";
        });

        $router->any("PUT | DELETE", "about", function () {
            echo "PUT+DELETE ";
        });

        ob_start();
        // try it out using some paths
        $router->handle("about", "GET");
        $router->handle("about", "POST");
        $router->handle("about", "PUT");
        $router->handle("about", "DELETE");
        // GET+POST GET+POST PUT+DELETE PUT+DELETE
        $res = ob_get_contents();
        ob_end_clean();
        $this->assertEquals($res, "GET+POST GET+POST PUT+DELETE PUT+DELETE ");
    }
}
