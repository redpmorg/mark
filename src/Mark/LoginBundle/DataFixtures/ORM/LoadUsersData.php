<?php
/**
 * Load User data for demo purpose
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-03 09:46:33
 * @version $Id$
 */

namespace Mark\LoginBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mark\LoginBundle\Entity\Users;

class LoadUsersData implements FixtureInterface
{
	/**
	 * {@inheritDoc}
	 * 0_ROLE_USER; 1_ROLE_ADMIN; 2_ROLE_SUPER_ADMIN
	 */
	public function load(ObjectManager $em)
	{

		// Leonard
		$user = new Users;
		$user->setFirstname('Leonard');
		$user->setLastname('Lepadatu');
		$user->setUsername('leo');
		$user->setEmail('leonardlepadatu@yahoo.com');
		$user->setPassword('leo');
		$user->setIsActive(1);
		$user->setUserRole(2); //
		$user->setLocale("ro");

		$em->persist($user);

	// Tiberiu
		$user = new Users;
		$user->setFirstname('Tiberiu');
		$user->setLastname('Lepadatu');
		$user->setUsername('tibi');
		$user->setEmail('tiberiulepadatu@yahoo.com');
		$user->setPassword('tibi');
		$user->setIsActive(1);
		$user->setUserRole(1); //
		$user->setLocale("en");

		$em->persist($user);

	// Luca
		$user = new Users;
		$user->setFirstname('Luca');
		$user->setLastname('Lepadatu');
		$user->setUsername('luca');
		$user->setEmail('lucalepadatu@yahoo.com');
		$user->setPassword('luca');
		$user->setIsActive(1);
		$user->setUserRole(0); //
		$user->setLocale("fr");

		$em->persist($user);

		$em->flush();
		$em->clear();
	}

}