<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AppRole;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @codeCoverageIgnore
 */
class LoadAppRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $objectManager)
    {
        $appRole = new AppRole();
        $appRole->setName('ROLE_USER');
        $objectManager->persist($appRole);
        $objectManager->flush($appRole);
        $this->addReference('app_role-role_user', $appRole);

        $appRole = new AppRole();
        $appRole->setName('ROLE_ADMIN');
        $objectManager->persist($appRole);
        $objectManager->flush($appRole);
        $this->addReference('app_role-role_admin', $appRole);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
