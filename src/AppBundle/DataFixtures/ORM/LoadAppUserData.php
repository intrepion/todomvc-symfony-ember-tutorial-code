<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AppUser;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @codeCoverageIgnore
 */
class LoadAppUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $objectManager)
    {
        $appUser = new AppUser();
        $appUser->setUsername('user');
        $appUser->setPassword('user');
        $appUser->addAppRole($this->getReference('app_role-role_user'));
        $objectManager->persist($appUser);
        $objectManager->flush($appUser);
        $this->addReference('app_user-user', $appUser);

        $appUser = new AppUser();
        $appUser->setUsername('admin');
        $appUser->setPassword('admin');
        $appUser->addAppRole($this->getReference('app_role-role_admin'));
        $objectManager->persist($appUser);
        $objectManager->flush($appUser);
        $this->addReference('app_user-admin', $appUser);
    }

    public function getOrder()
    {
        return 2;
    }
}
