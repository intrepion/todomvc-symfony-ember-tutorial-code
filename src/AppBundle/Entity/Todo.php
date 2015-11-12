<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TodoRepository")
 */
class Todo
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isCompleted", type="boolean")
     */
    private $isCompleted;


    /**
     * Constructor
     */
    public function __construct()
    {
        
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
     * Set title
     *
     * @param string $title
     *
     * @return Todo
     */
    public function setTitle($title)
    {
        if (false === is_string($title)) {
            throw new \InvalidArgumentException;
        }
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isCompleted
     *
     * @param boolean $isCompleted
     *
     * @return Todo
     */
    public function setIsCompleted($isCompleted)
    {
        if (false === is_bool($isCompleted)) {
            throw new \InvalidArgumentException;
        }
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * Get isCompleted
     *
     * @return boolean
     */
    public function getIsCompleted()
    {
        return $this->isCompleted;
    }
}
