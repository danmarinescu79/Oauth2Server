<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 13:58:41
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-14 14:15:38
 */

namespace Oauth2Server;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    
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
