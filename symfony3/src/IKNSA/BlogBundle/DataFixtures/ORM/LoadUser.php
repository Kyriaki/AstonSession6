<?php

namespace IKNSA\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUser extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function load(ObjectManager $manager)
    {
    	$userManager = $this->getContainer->get('fos_user.user_manager');

    	$user = $userManager->createUser();
		$user->setUsername('user');
		$user->setEmail('user@iknsa.com');
		$user->setPlainPassword('user');
		$user->setEnabled(true);
		$user->setLastLogin(new \Datetime('NOW'));
		$user->setRoles(array('ROLE_USER'));

		$admin = $userManager->createUser();
		$admin->setUsername('admin');
		$admin->setEmail('admin@iknsa.com');
		$admin->setPlainPassword('admin');
		$admin->setEnabled(true);
		$admin->setLastLogin(new \Datetime('NOW'));
		$admin->setRoles(array('ROLE_ADMIN', 'ROLE_USER'));

		$manager->persist($user);
		$manager->persist($admin);

		$manager->flush();

		$this->addReference('admin-admin', $admin);
    } 

    public function getOrder()
	{
	    return 100;
	}

    public function setContainer(ContainerInterface $container = null)
    {
        $this->getContainer = $container;
    }
}