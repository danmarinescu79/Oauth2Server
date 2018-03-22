<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-20 18:13:49
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-20 23:28:09
 */

namespace Oauth2Server\Factory\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\RefreshToken;
use OAuth2\GrantType\UserCredentials;
use Oauth2Server\Entity\OAuthAccessToken;
use Oauth2Server\Entity\OAuthClient;
use Oauth2Server\Entity\OAuthRefreshToken;
use Oauth2Server\Entity\OAuthUser;
use Zend\ServiceManager\Factory\FactoryInterface;

class Oauth2 implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $clientStorage       = $container->get(EntityManager::class)->getRepository(OAuthClient::class);
        $userStorage         = $container->get(EntityManager::class)->getRepository(OAuthUser::class);
        $accessTokenStorage  = $container->get(EntityManager::class)->getRepository(OAuthAccessToken::class);
        $refreshTokenStorage = $container->get(EntityManager::class)->getRepository(OAuthRefreshToken::class);

        $server = new \OAuth2\Server([
            'client_credentials' => $clientStorage,
            'user_credentials'   => $userStorage,
            'access_token'       => $accessTokenStorage,
            'refresh_token'      => $refreshTokenStorage,
        ], [
            'always_issue_new_refresh_token' => true,
            'allow_implicit'                 => true,
            'auth_code_lifetime'             => 30,
            'refresh_token_lifetime'         => 2419200,
        ]);

        $server->addGrantType(new ClientCredentials($clientStorage));
        $server->addGrantType(new UserCredentials($userStorage));

        $server->addGrantType(new RefreshToken($refreshTokenStorage, [
            'always_issue_new_refresh_token' => true,
        ]));

        return $server;
    }
}
