<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 13:58:41
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-22 12:23:23
 */

namespace Oauth2Server;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'oauth-token-info' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/oauth/info',
                    'defaults' => [
                        'controller' => Controller\Oauth2::class,
                    ],
                ],
            ],
            'oauth-token' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/oauth/token',
                    'defaults' => [
                        'controller' => Controller\Oauth2::class,
                    ],
                ],
            ],
            'oauth-revoke' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/oauth/revoke',
                    'defaults' => [
                        'controller' => Controller\Oauth2::class,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\Oauth2::class => Factory\Controller\Oauth2::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Oauth2Server::class => Factory\Service\Oauth2::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];
