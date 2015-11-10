<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\AppRole;
use AppBundle\Entity\AppUser;

/**
 * @covers AppBundle\Entity\AppUser::__construct
 */
class AppUserTest extends \PHPUnit_Framework_TestCase
{
    private $appUser;

    public function setUp()
    {
        $this->appUser = new AppUser();
    }

    /**
     * @covers AppBundle\Entity\AppUser::getId
     */
    public function testGetIdStartsNull()
    {
        $this->assertNull($this->appUser->getId());
    }

    /**
     * @covers AppBundle\Entity\AppUser::getUsername
     */
    public function testGetUsernameStartsNull()
    {
        $this->assertNull($this->appUser->getUsername());
    }

    /**
     * @covers AppBundle\Entity\AppUser::setUsername
     * @covers AppBundle\Entity\AppUser::getUsername
     */
    public function testSetUsernameWithString()
    {
        $username = 'some username';
        $this->appUser->setUsername($username);
        $this->assertEquals($username, $this->appUser->getUsername());
    }

    /**
     * @covers AppBundle\Entity\AppUser::setUsername
     * @expectedException \InvalidArgumentException
     */
    public function testSetUsernameWithNull()
    {
        $this->appUser->setUsername(null);
    }

    /**
     * @covers AppBundle\Entity\AppUser::setUsername
     * @expectedException \InvalidArgumentException
     */
    public function testSetUsernameWithInteger()
    {
        $this->appUser->setUsername(4);
    }

    /**
     * @covers AppBundle\Entity\AppUser::getPassword
     */
    public function testGetPasswordStartsNull()
    {
        $this->assertNull($this->appUser->getPassword());
    }

    /**
     * @covers AppBundle\Entity\AppUser::setPassword
     * @covers AppBundle\Entity\AppUser::getPassword
     */
    public function testSetPasswordWithString()
    {
        $password = 'some username';
        $this->appUser->setPassword($password);
        $this->assertEquals($password, $this->appUser->getPassword());
    }

    /**
     * @covers AppBundle\Entity\AppUser::setPassword
     * @expectedException \InvalidArgumentException
     */
    public function testSetPasswordWithNull()
    {
        $this->appUser->setPassword(null);
    }

    /**
     * @covers AppBundle\Entity\AppUser::setPassword
     * @expectedException \InvalidArgumentException
     */
    public function testSetPasswordWithInteger()
    {
        $this->appUser->setPassword(4);
    }

    /**
     * @covers AppBundle\Entity\AppUser::getAppRole
     */
    public function testGetAppRoleStartsCollection()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $this->appUser->getAppRole());
    }

    /**
     * @covers AppBundle\Entity\AppUser::addAppRole
     * @covers AppBundle\Entity\AppUser::removeAppRole
     * @covers AppBundle\Entity\AppUser::getAppRole
     * @covers AppBundle\Entity\AppUser::getRoles
     */
    public function testAddAppRoleWithAppRole()
    {
        $appRole1 = new AppRole();
        $appRole1->setName('ROLE_ONE');
        $appRole2 = new AppRole();
        $appRole2->setName('ROLE_TWO');
        $this->appUser->addAppRole($appRole1);
        $this->appUser->addAppRole($appRole2);
        $appRoleCollection = $this->appUser->getAppRole();
        $this->assertEquals($appRole1, $appRoleCollection->first());
        $this->assertEquals($appRole2, $appRoleCollection->last());
        $this->assertContains('ROLE_ONE', $this->appUser->getRoles());
        $this->assertContains('ROLE_TWO', $this->appUser->getRoles());
        $this->appUser->removeAppRole($appRole1);
        $appRoleCollection = $this->appUser->getAppRole();
        $this->assertEquals($appRole2, $appRoleCollection->first());
        $this->assertEquals($appRole2, $appRoleCollection->last());
        $this->assertNotContains('ROLE_ONE', $this->appUser->getRoles());
        $this->assertContains('ROLE_TWO', $this->appUser->getRoles());
    }

    /**
     * @covers AppBundle\Entity\AppUser::addAppRole
     * @expectedException \InvalidArgumentException
     */
    public function testAddAppRoleWithNull()
    {
        try {
            $this->appUser->addAppRole(null);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException;
        }
    }

    /**
     * @covers AppBundle\Entity\AppUser::addAppRole
     * @expectedException \InvalidArgumentException
     */
    public function testAddAppRoleWithInteger()
    {
        try {
            $this->appUser->addAppRole(4);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException;
        }
    }

    /**
     * @covers AppBundle\Entity\AppUser::getSalt
     */
    public function testGetSaltStartsNull()
    {
        $this->assertNull($this->appUser->getSalt());
    }

    /**
     * @covers AppBundle\Entity\AppUser::eraseCredentials
     */
    public function testEraseCredentialsStartsNull()
    {
        $this->assertNull($this->appUser->eraseCredentials());
    }
}
