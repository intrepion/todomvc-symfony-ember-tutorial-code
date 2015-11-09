<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * AppUser
 *
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AppUserRepository")
 */
class AppUser implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="AppRole", inversedBy="appUser")
     * @ORM\JoinTable(name="app_user__app_role",
     *     joinColumns={@ORM\JoinColumn(name="app_user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="app_role_id", referencedColumnName="id")}
     * )
     */
    private $appRole;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->appRole = new ArrayCollection();
    }

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
     * Set username
     *
     * @param string $username
     *
     * @return AppUser
     */
    public function setUsername($username)
    {
        if (false === is_string($username)) {
            throw new \InvalidArgumentException;
        }
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return AppUser
     */
    public function setPassword($password)
    {
        if (false === is_string($password)) {
            throw new \InvalidArgumentException;
        }
        $this->password = $password;

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
     * Add appRole
     *
     * @param AppRole $appRole
     *
     * @return AppUser
     */
    public function addAppRole(AppRole $appRole)
    {
        $this->appRole[] = $appRole;

        return $this;
    }

    /**
     * Remove appRole
     *
     * @param AppRole $appRole
     */
    public function removeAppRole(AppRole $appRole)
    {
        $this->appRole->removeElement($appRole);
    }

    /**
     * Get appRole
     *
     * @return Collection
     */
    public function getAppRole()
    {
        return $this->appRole;
    }

    /**
     * Get salt
     */
    public function getSalt()
    {
    }

    /**
     * Get roles
     *
     * @return array;
     */
    public function getRoles()
    {
        return $this->appRole->map(
            function($appRole) {
                return $appRole->getRole();
            }
        )->toArray();
    }

    /**
     * Erase credentials
     */
    public function eraseCredentials()
    {
    }
}
