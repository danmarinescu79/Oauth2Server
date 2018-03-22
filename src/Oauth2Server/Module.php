<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 14:00:08
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-21 15:02:40
 */

namespace Oauth2Server;

use Oauth2Server\Listener\ApiAuth;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $request = $event->getApplication()->getRequest();
        if (!$request instanceof ConsoleRequest) {
            $aggregate = new ApiAuth();
            $aggregate->attach($event->getApplication()->getEventManager());
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
