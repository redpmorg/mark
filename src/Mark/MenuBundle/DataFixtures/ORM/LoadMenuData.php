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
		$menu->setName('Parent_'.$i);
		$menu->setDescription('Parent_'.$i." description");
		$menu->setParent(0);
		$menu->setRoute("parent/".$i);
		$menu->setIsActive(0==$i%2 ? 1 : 0);
		$menu->setRoles(0);
		$menu->setSort($i);

		$em->persist($menu);
	}

	$em->flush();
	$em->clear();

	for($i=1; $i<21; $i++)
	{
		$menu = new Menu();
		$menu->setName('Child_'.$i);

		if($i<=20) {$p = 4;}
		if($i<=15) {$p = 3;}
		if($i<=10) {$p = 2;}
		if($i<=5)  {$p = 1;}

		$menu->setDescription("Child_{$i} of parent_{$p}  description");
		$menu->setParent($p);

		$menu->setRoute("child/".$i);
		$menu->setIsActive(1);
		$menu->setRoles(0);
		$menu->setSort($i);

		$em->persist($menu);

	}

	$em->flush();
	$em->clear();

   }
}