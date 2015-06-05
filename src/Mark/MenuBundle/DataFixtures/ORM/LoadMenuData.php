<?php
/**
 * Menu Data Fixtures for demo purpose
 *
 * @authors Leonard Lepadatu (leonardlepadatu@yahoo.com)
 * @date    2015-06-03 00:15:07
 * @version $Id$
 */

namespace Mark\MenuBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mark\MenuBundle\Entity\Menu;

class LoadMenuData implements FixtureInterface
{
   /**
	 * {@inheritDoc}
	 */
   public function load(ObjectManager $em)
   {

	for($i=1; $i<5; $i++)
	{
		$menu = new Menu();
		$menu->setParentId($i);
		$menu->setName("Parent_{$i}");
		$menu->setDescription("Parent_{$i} description");
		$menu->setParent(0);
		$menu->setRoute("parent/{$i}");
		$menu->setIsActive(1);
		$menu->setRoles(0);
		$menu->setSort($i);

		$em->persist($menu);
	}

	$em->flush();
	$em->clear();

	for($i=1; $i<41; $i++)
	{
		$menu = new Menu();
		$menu->setParentId(0);

		if($i<=40) {$p = 4;}
		if($i<=30) {$p = 3;}
		if($i<=20) {$p = 2;}
		if($i<=10)  {$p = 1;}

		$menu->setName("Child_{$i} of {$p}");
		$menu->setDescription("Child_{$i} of {$p} description");
		$menu->setParent($p);

		$menu->setRoute("child/{$i}");
		$menu->setIsActive(1);
		$menu->setRoles(0);
		$menu->setSort($i);

		$em->persist($menu);

	}

	$em->flush();
	$em->clear();

   }
}