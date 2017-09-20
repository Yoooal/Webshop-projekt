<?php

namespace Anax\Common;

/**
 * Interface for classes needing injection of the $app object
 * containing framework resources.
 */
interface AppInjectableInterface
{
    /**
     * Inject the $app into this class.
     *
     * @param object $app containing framework resources.
     *
     * @return $this for chaining.
     */
    public function setApp($app);
}
