<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:14:29
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-14 16:14:57
 */

namespace Oauth2Server\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\AccessTokenInterface;
use Oauth2Server\Entity\OAuthAccessToken;

class OAuthAccessTokenRepository extends EntityRepository implements AccessTokenInterface
{
    public function getAccessToken($oauthToken)
    {
        $token = $this->findOneBy(['token' => $oauthToken]);
        if ($token) {
            $token            = $token->toArray();
            $token['expires'] = $token['expires']->getTimestamp();
        }
        return $token;
    }

    public function setAccessToken($oauthToken, $clientIdentifier, $userEmail, $expires, $scope = null)
    {
        $client = $this->_em->getRepository('Oauth2Server\Entity\OAuthClient')
                            ->findOneBy(['client_identifier' => $clientIdentifier]);
        $user = $this->_em->getRepository('Oauth2Server\Entity\OAuthUser')
                            ->findOneBy(['email' => $userEmail]);
        $token = OAuthAccessToken::fromArray([
            'token'   => $oauthToken,
            'client'  => $client,
            'user'    => $user,
            'expires' => (new \DateTime())->setTimestamp($expires),
            'scope'   => $scope,
        ]);
        $this->_em->persist($token);
        $this->_em->flush();
    }
}
