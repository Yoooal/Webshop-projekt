<?php

namespace Anax\DI;

/**
 * DI factory class creating a set of default services into the DI container.
 */
class DIFactoryDefault extends DI
{
   /**
     * Constructor creating a set of services included into this DI container.
     */
    public function __construct()
    {
        $this->setShared("request", function () {
            $request = new \Anax\Request\Request();
            $request->init();
            return $request;
        });

        $this->setShared("response", "\Anax\Response\Response");

        $this->setShared("url", function () {
            $url = new \Anax\Url\Url();
            $request = $this->get("request");
            $url->setSiteUrl($request->getSiteUrl());
            $url->setBaseUrl($request->getBaseUrl());
            $url->setStaticSiteUrl($request->getSiteUrl());
            $url->setStaticBaseUrl($request->getBaseUrl());
            $url->setScriptName($request->getScriptName());
            $url->configure("url.php");
            $url->setDefaultsFromConfiguration();
            return $url;
        });

        $this->setShared("router", function () {
            $router = new \Anax\Route\Router();
            $router->setDI($this);
            return $router;
        });

        $this->setShared("view", function () {
            $view = new \Anax\View\ViewContainer();
            $view->configure("view.php");
            $view->setDI($this);
            return $view;
        });

        $this->setShared("viewRenderFile", function () {
            $viewRender = new \Anax\View\ViewRenderFile2();
            $viewRender->setDI($this);
            return $viewRender;
        });

        $this->setShared("session", function () {
            $session = new \Anax\Session\SessionConfigurable();
            $session->configure("session.php");
            return $session;
        });

        $this->setShared("textfilter", "\Anax\TextFilter\TextFilter");
    }
}
