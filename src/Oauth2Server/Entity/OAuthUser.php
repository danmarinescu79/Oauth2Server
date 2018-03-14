<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 14:16:39
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-03-14 15:47:47
 */

namespace Oauth2Server\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OAuthUser
 *
 * @ORM\Table(name="oauth_users", indexes={@ORM\Index(name="email_index", columns={"email"}), @ORM\Index(name="search_index", columns={"name", "email"})})
 * @ORM\Entity(repositoryClass="Oauth2Server\Repository\OAuthUserRepository")
 */
class OAuthUser extends EncryptableFieldEntity
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=130, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     */
    private $password;

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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $this->encryptField($password);
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Verify user's password
     *
     * @param string $password
     * @return Boolean
     */
    public function verifyPassword($password)
    {
        return $this->verifyEncryptedFieldValue($this->getPassword(), $password);
    }

    public function toArray()
    {
        return [
            'user_id' => $this->id,
            'scope'   => null,
        ];
    }
}
