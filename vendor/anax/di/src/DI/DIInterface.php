<?php

namespace Anax\DI;

use Anax\DI\Exception\Exception;
use Anax\DI\Exception\NotFoundException;

/**
 * A DI class used with Anax should implement this interface.
 *
 */
interface DIInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $service     Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws Exception          Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($service);



    /**
     * Returns true if the container can return an entry for the given
     * identifier, otherwise false
     *
     * `has($id)` returning true does not mean that `get($id)` will not
     * throw an exception.
     * It does however mean that `get($id)` will not throw a
     * `NotFoundException`.
     *
     * @param string $service Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($service);
}
