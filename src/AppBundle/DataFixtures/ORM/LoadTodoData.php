<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Todo;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @codeCoverageIgnore
 */
class LoadTodoData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $objectManager)
    {
        $todo = new Todo();
        $todo->setTitle('Finish creating example project');
        $todo->setIsCompleted(true);
        $objectManager->persist($todo);
        $objectManager->flush($todo);
        $this->addReference('todo-finish_creating_example_project', $todo);

        $todo = new Todo();
        $todo->setTitle('Finish writing tutorial');
        $todo->setIsCompleted(false);
        $objectManager->persist($todo);
        $objectManager->flush($todo);
        $this->addReference('todo-finish_writing_tutorial', $todo);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
