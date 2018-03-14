<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:24:19
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-14 16:24:37
 */

namespace Oauth2Server\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\RefreshTokenInterface;
use Oauth2Server\Entity\OAuthRefreshToken;

class OAuthRefreshTokenRepository extends EntityRepository implements RefreshTokenInterface
{
    public function getRefreshToken($refreshToken)
    {
        $refreshToken = $this->findOneBy(['refresh_token' => $refreshToken]);
        if ($refreshToken) {
            $refreshToken            = $refreshToken->toArray();
            $refreshToken['expires'] = $refreshToken['expires']->getTimestamp();
        }
        return $refreshToken;
    }

    public function setRefreshToken($refreshToken, $clientIdentifier, $userEmail, $expires, $scope = null)
    {
        $client = $this->_em->getRepository('Oauth2Server\Entity\OAuthClient')
                            ->findOneBy(['client_identifier' => $clientIdentifier]);
        $user = $this->_em->getRepository('Oauth2Server\Entity\OAuthUser')
                            ->findOneBy(['email' => $userEmail]);
        $refreshToken = OAuthRefreshToken::fromArray([
           'refresh_token' => $refreshToken,
           'client'        => $client,
           'user'          => $user,
           'expires'       => (new \DateTime())->setTimestamp($expires),
           'scope'         => $scope,
        ]);
        $this->_em->persist($refreshToken);
        $this->_em->flush();
    }

    public function unsetRefreshToken($refreshToken)
    {
        $refreshToken = $this->findOneBy(['refresh_token' => $refreshToken]);
        $this->_em->remove($refreshToken);
        $this->_em->flush();
    }
}
