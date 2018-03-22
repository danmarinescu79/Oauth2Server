<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 14:01:34
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-16 12:03:55
 */

namespace Oauth2Server\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OAuthClient
 *
 * @ORM\Table(name="oauth_clients")
 * @ORM\Entity(repositoryClass="Oauth2Server\Repository\OAuthClientRepository")
 */
class OAuthClient extends EncryptableFieldEntity
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
     * @ORM\Column(name="client_identifier", type="string", length=50, unique=true)
     */
    private $client_identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="client_secret", type="string", length=120)
     */
    private $client_secret;

    /**
     * @var string
     *
     * @ORM\Column(name="redirect_uri", type="string", length=255, options={"default"=""})
     */
    private $redirect_uri = '';

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
     * Set client_identifier
     *
     * @param string $clientIdentifier
     * @return OAuthClient
     */
    public function setClientIdentifier($clientIdentifier)
    {
        $this->client_identifier = $clientIdentifier;
        return $this;
    }

    /**
     * Get client_identifier
     *
     * @return string
     */
    public function getClientIdentifier()
    {
        return $this->client_identifier;
    }

    /**
     * Set client_secret
     *
     * @param string $clientSecret
     * @return OAuthClient
     */
    public function setClientSecret($clientSecret)
    {
        $this->client_secret = $this->encryptField($clientSecret);
        return $this;
    }

    /**
     * Get client_secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Verify client's secret
     *
     * @param string $password
     * @return Boolean
     */
    public function verifyClientSecret($clientSecret)
    {
        return $this->verifyEncryptedFieldValue($this->getClientSecret(), $clientSecret);
    }

    /**
     * Set redirect_uri
     *
     * @param string $redirectUri
     * @return OAuthClient
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirect_uri = $redirectUri;
        return $this;
    }

    /**
     * Get redirect_uri
     *
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    public function toArray()
    {
        return [
            'client_id'     => $this->client_identifier,
            'client_secret' => $this->client_secret,
            'redirect_uri'  => $this->redirect_uri,
        ];
    }
}
