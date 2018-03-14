<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:00:08
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-14 16:22:21
 */

namespace Oauth2Server\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OAuthAccessToken
 *
 * @ORM\Table(name="oauth_access_tokens")
 * @ORM\Entity(repositoryClass="Oauth2Server\Repository\OAuthAccessTokenRepository")
 */
class OAuthAccessToken
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=40, unique=true)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires",type="datetime", nullable=false)
     */
    private $expires;

    /**
     * @var string
     *
     * @ORM\Column(name="scope", type="string", length=50, nullable=true)
     */
    private $scope;

    /**
     * @var \Oauth2Server\Entity\OAuthClient
     *
     * @ORM\ManyToOne(targetEntity="\Oauth2Server\Entity\OAuthClient")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @var \Oauth2Server\Entity\OAuthUser
     *
     * @ORM\ManyToOne(targetEntity="\Oauth2Server\Entity\OAuthUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return OAuthAccessToken
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set expires
     *
     * @param \DateTime $expires
     * @return OAuthAccessToken
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set scope
     *
     * @param string $scope
     * @return OAuthAccessToken
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set client
     *
     * @param \Oauth2Server\Entity\OAuthClient $client
     * @return OAuthAccessToken
     */
    public function setClient(\Oauth2Server\Entity\OAuthClient $client = null)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get client
     *
     * @return \Oauth2Server\Entity\OAuthClient
     */
    public function getClient()
    {
        return $this->client;
    }

    public static function fromArray($params)
    {
        $token = new self();
        foreach ($params as $property => $value) {
            $token->$property = $value;
        }
        return $token;
    }

    /**
     * Set user
     *
     * @param \Oauth2Server\Entity\OAuthUser $user
     * @return OAuthRefreshToken
     */
    public function setUser(\Oauth2Server\Entity\OAuthUser $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return \Oauth2Server\Entity\OAuthUser
     */
    public function getUser()
    {
        return $this->client;
    }

    public function toArray()
    {
        return [
            'token'     => $this->token,
            'client_id' => $this->client_id,
            'user_id'   => $this->user_id,
            'expires'   => $this->expires,
            'scope'     => $this->scope,
        ];
    }
}
