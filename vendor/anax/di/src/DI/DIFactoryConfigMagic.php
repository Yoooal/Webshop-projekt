<?php

namespace Anax\DI;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;

/**
 * DI factory class creating a set of default services by loading
 * them from a configuration file and allowing use of magic methods
 * to access the services.
 */
class DIFactoryConfigMagic extends DIFactoryConfig
{
    use DIMagicTrait;
}
