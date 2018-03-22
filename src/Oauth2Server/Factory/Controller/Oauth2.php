<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:27:49
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-20 18:20:01
 */

namespace Oauth2Server\Factory\Controller;

use Interop\Container\ContainerInterface;
use Oauth2Server\Controller\Oauth2 as Controller;
use Zend\ServiceManager\Factory\FactoryInterface;

class Oauth2 implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Controller(
            $container->get(\Oauth2Server::class)
        );
    }
}
