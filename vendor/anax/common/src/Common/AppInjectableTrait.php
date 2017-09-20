<?php

namespace Anax\Common;

/**
 * Trait implementing AppInjectableInterface for classes which need to
 * be injectad with the $app.
 */
trait AppInjectableTrait
{
    /**
     * Properties
     *
     */
    private $app;  // Contains all framework resources.



    /**
     * Inject the $app into this class.
     *
     * @param object $app containing framework resources.
     *
     * @return $this for chaining.
     */
    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }
}
