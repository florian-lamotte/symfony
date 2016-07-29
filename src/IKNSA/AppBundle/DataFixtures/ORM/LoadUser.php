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
    public function load(ObjectManager $manager)
    {
    	$userManager = $this->getContainer->get('fos_user.user_manager');

    	$dupont = $userManager->createUser();
		$dupont->setUsername('dupont');
		$dupont->setEmail('dupont@gmail.com');
		$dupont->setPlainPassword('dupont');
		$dupont->setEnabled(true);
		$dupont->setLastLogin(new \Datetime('NOW'));
		$dupont->setRoles(array('ROLE_COMMENTATOR'));
		$manager->persist($dupont);

		$admin = $userManager->createUser();
		$admin->setUsername('admin');
		$admin->setEmail('admin@gmail.com');
		$admin->setPlainPassword('admin');
		$admin->setEnabled(true);
		$admin->setLastLogin(new \Datetime('NOW'));
		$admin->setRoles(array('ROLE_CONTRIBUTOR'));
		$manager->persist($admin);

		$coucou = $userManager->createUser();
		$coucou->setUsername('coucou');
		$coucou->setEmail('coucou@gmail.com');
		$coucou->setPlainPassword('coucou');
		$coucou->setEnabled(true);
		$coucou->setLastLogin(new \Datetime('NOW'));
		$coucou->setRoles(array('ROLE_COMMENTATOR'));
		$manager->persist($coucou);

		$manager->flush();

		$this->addReference('admin-admin', $admin);
    }

    private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->getContainer = $container;
	}

	public function getOrder()
	{
		return 100;
	}
}
