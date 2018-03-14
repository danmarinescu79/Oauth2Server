<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 14:00:08
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-14 14:00:25
 */

namespace Oauth2Server;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
