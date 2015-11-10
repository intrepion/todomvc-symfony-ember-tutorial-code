<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\AppRole;
use AppBundle\Entity\AppUser;

/**
 * @covers AppBundle\Entity\AppRole::__construct
 */
class AppRoleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AppRole
     */
    private $appRole;

    public function setUp()
    {
        $this->appRole = new AppRole();
    }

    /**
     * @covers AppBundle\Entity\AppRole::getId
     */
    public function testGetIdStartsNull()
    {
        $this->assertNull($this->appRole->getId());
    }

    /**
     * @covers AppBundle\Entity\AppRole::getName
     */
    public function testGetNameStartsNull()
    {
        $this->assertNull($this->appRole->getName());
    }

    /**
     * @covers AppBundle\Entity\AppRole::setName
     * @covers AppBundle\Entity\AppRole::getName
     * @covers AppBundle\Entity\AppRole::getRole
     */
    public function testSetNameWithString()
    {
        $name = 'some name';
        $this->appRole->setName($name);
        $this->assertEquals($name, $this->appRole->getName());
        $this->assertEquals($name, $this->appRole->getRole());
    }

    /**
     * @covers AppBundle\Entity\AppRole::setName
     * @expectedException \InvalidArgumentException
     */
    public function testSetNameWithNull()
    {
        $this->appRole->setName(null);
    }

    /**
     * @covers AppBundle\Entity\AppRole::setName
     * @expectedException \InvalidArgumentException
     */
    public function testSetNameWithInteger()
    {
        $this->appRole->setName(4);
    }

    /**
     * @covers AppBundle\Entity\AppRole::getAppUser
     */
    public function testGetAppUserStartsCollection()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $this->appRole->getAppUser());
    }

    /**
     * @covers AppBundle\Entity\AppRole::addAppUser
     * @covers AppBundle\Entity\AppRole::removeAppUser
     * @covers AppBundle\Entity\AppRole::getAppUser
     */
    public function testAddAppUserWithAppUser()
    {
        $appUser1 = new AppUser();
        $appUser2 = new AppUser();
        $this->appRole->addAppUser($appUser1);
        $this->appRole->addAppUser($appUser2);
        $appUserCollection = $this->appRole->getAppUser();
        $this->assertEquals($appUser1, $appUserCollection->first());
        $this->assertEquals($appUser2, $appUserCollection->last());
        $this->appRole->removeAppUser($appUser1);
        $appUserCollection = $this->appRole->getAppUser();
        $this->assertEquals($appUser2, $appUserCollection->first());
        $this->assertEquals($appUser2, $appUserCollection->last());
    }

    /**
     * @covers AppBundle\Entity\AppRole::addAppUser
     * @expectedException \InvalidArgumentException
     */
    public function testAddAppUserWithNull()
    {
        try {
            $this->appRole->addAppUser(null);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException;
        } catch (\Error $error) {
            throw new \InvalidArgumentException;
        }
    }

    /**
     * @covers AppBundle\Entity\AppRole::addAppUser
     * @expectedException \InvalidArgumentException
     */
    public function testAddAppUserWithInteger()
    {
        try {
            $this->appRole->addAppUser(4);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException;
        } catch (\Error $error) {
            throw new \InvalidArgumentException;
        }
    }
}
