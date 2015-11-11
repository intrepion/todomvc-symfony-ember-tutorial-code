<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AppUser;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
class LoadAppUserData
    extends AbstractFixture
    implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $objectManager)
    {
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder(new AppUser());

        $appUser = new AppUser();
        $appUser->setUsername('user');
        $appUser->setPassword(
            $encoder->encodePassword(
                $appUser->getUsername(),
                $appUser->getSalt()
            )
        );
        $appUser->addAppRole($this->getReference('app_role-role_user'));
        $objectManager->persist($appUser);
        $objectManager->flush($appUser);
        $this->addReference('app_user-user', $appUser);

        $appUser = new AppUser();
        $appUser->setUsername('admin');
        $appUser->setPassword(
            $encoder->encodePassword(
                $appUser->getUsername(),
                $appUser->getSalt()
            )
        );
        $appUser->addAppRole($this->getReference('app_role-role_admin'));
        $objectManager->persist($appUser);
        $objectManager->flush($appUser);
        $this->addReference('app_user-admin', $appUser);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
