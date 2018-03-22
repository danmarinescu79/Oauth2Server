<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:27:42
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-22 12:24:23
 */

namespace Oauth2Server\Controller;

use OAuth2\Server;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class Oauth2 extends AbstractRestfulController
{
    private $server;
    
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function getList()
    {
        $oauth = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());

        return new JsonModel($oauth);
    }
}
