<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Todo;
use AppBundle\Entity\AppUser;

/**
 * @covers AppBundle\Entity\Todo::__construct
 */
class TodoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Todo
     */
    private $todo;

    public function setUp()
    {
        $this->todo = new Todo();
    }

    /**
     * @covers AppBundle\Entity\Todo::getId
     */
    public function testGetIdStartsNull()
    {
        $this->assertNull($this->todo->getId());
    }

    /**
     * @covers AppBundle\Entity\Todo::getTitle
     */
    public function testGetTitleStartsNull()
    {
        $this->assertNull($this->todo->getTitle());
    }

    /**
     * @covers AppBundle\Entity\Todo::setTitle
     * @covers AppBundle\Entity\Todo::getTitle
     */
    public function testSetTitleWithString()
    {
        $title = 'some name';
        $this->todo->setTitle($title);
        $this->assertEquals($title, $this->todo->getTitle());
    }

    /**
     * @covers AppBundle\Entity\Todo::setTitle
     * @expectedException \InvalidArgumentException
     */
    public function testSetTitleWithNull()
    {
        $this->todo->setTitle(null);
    }

    /**
     * @covers AppBundle\Entity\Todo::setTitle
     * @expectedException \InvalidArgumentException
     */
    public function testSetTitleWithInteger()
    {
        $this->todo->setTitle(4);
    }

    /**
     * @covers AppBundle\Entity\Todo::getIsCompleted
     */
    public function testGetIsCompletedStartsNull()
    {
        $this->assertNull($this->todo->getIsCompleted());
    }

    /**
     * @covers AppBundle\Entity\Todo::setIsCompleted
     * @covers AppBundle\Entity\Todo::getIsCompleted
     */
    public function testSetIsCompletedWithBoolean()
    {
        $isComplete = false;
        $this->todo->setIsCompleted($isComplete);
        $this->assertEquals($isComplete, $this->todo->getIsCompleted());
    }

    /**
     * @covers AppBundle\Entity\Todo::setIsCompleted
     * @expectedException \InvalidArgumentException
     */
    public function testSetIsCompletedWithNull()
    {
        $this->todo->setIsCompleted(null);
    }

    /**
     * @covers AppBundle\Entity\Todo::setIsCompleted
     * @expectedException \InvalidArgumentException
     */
    public function testSetIsCompletedWithInteger()
    {
        $this->todo->setIsCompleted(4);
    }
}
