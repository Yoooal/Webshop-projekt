<?php

namespace Anax\Response;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * Handling a response and includes utilitie methods.
 */
class ResponseUtility extends Response implements
    InjectionAwareInterface
{
    use InjectionAwareTrait;



    /**
     * Redirect to another page and creating an url from the argument.
     *
     * @param string $url to redirect to
     *
     * @return void
     */
    public function redirect($url)
    {
        parent::redirect($this->di->get("url")->create($url));
    }



    /**
     * Redirect to current page.
     *
     * @return void
     */
    public function redirectSelf()
    {
        $url = $this->di->get("request")->getCurrentUrl();
        parent::redirect($this->di->get("url")->create($url));
    }
}
