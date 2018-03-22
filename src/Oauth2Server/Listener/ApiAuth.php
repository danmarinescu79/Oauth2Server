<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-20 17:50:55
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-22 12:20:16
 */

namespace Oauth2Server\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class ApiAuth implements ListenerAggregateInterface
{
    private $listeners = [];

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRoute'], $priority);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function onRoute(MvcEvent $event)
    {
        $application  = $event->getApplication();
        $container    = $application->getServiceManager();
        $oauth2Server = $container->get(\Oauth2Server::class);
        $route        = $event->getRouteMatch()->getMatchedRouteName();
        $method       = $event->getRequest()->getMethod();

        if ($route == 'oauth-token' && strtolower($method) == 'post') {
            $response = $oauth2Server->handleTokenRequest(\OAuth2\Request::createFromGlobals());
            $response->send();
            $event->stopPropagation(true);
            exit;
        }

        $isValid = $oauth2Server->verifyResourceRequest(\OAuth2\Request::createFromGlobals());

        if (!$isValid) {
            return new ApiProblemResponse(new ApiProblem(401, 'Unauthorized'));
        }

        if ($route == 'oauth-revoke' && strtolower($method) == 'post') {
            $response = $oauth2Server->handleRevokeRequest(\OAuth2\Request::createFromGlobals());
            $response->send();
            $event->stopPropagation(true);
            exit;
        }
    }
}
