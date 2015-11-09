<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * AppRole
 *
 * @ORM\Table(name="app_role")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AppRoleRepository")
 */
class AppRole implements RoleInterface
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppUser", mappedBy="appRole")
     */
    private $appUser;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->appUser = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return AppRole
     */
    public function setName($name)
    {
        if (false === is_string($name)) {
            throw new \InvalidArgumentException;
        }
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->name;
    }

    /**
     * Add appUser
     *
     * @param AppUser $appUser
     *
     * @return AppRole
     */
    public function addAppUser(AppUser $appUser)
    {
        $this->appUser[] = $appUser;

        return $this;
    }

    /**
     * Remove appUser
     *
     * @param AppUser $appUser
     */
    public function removeAppUser(AppUser $appUser)
    {
        $this->appUser->removeElement($appUser);
    }

    /**
     * Get appUser
     *
     * @return Collection
     */
    public function getAppUser()
    {
        return $this->appUser;
    }
}
