<?php
/**
 * Menu Administrate Form
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-04 15:16:41
 * @version $Id$
 */

namespace Mark\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;

use Mark\MenuBundle\Controller\MenuController;
use Mark\Entity\Menu;

class ManageMenuController extends MenuController
{

	/**
	 * Menu Browse
	 * @Route("/sadm/manmenu", name="menu_manage")
	 * @Template("MarkMenuBundle:Default:menu_browse.html.twig")
	 */
	public function menuManageAction()
	{
		$data["menu_columns"] = $this->generateMenuColumnsAction();
		$data["menu_rows"] = $this->generateMenuAction(true);

		$data["title"] = "Menu Manager";

		return $data;
	}

	/**
	 * Menu Edit
	 * @Route("/sadm/manmenu/add/{id}", name="menu_add", defaults={"id" = null})
	 * @Route("/sadm/manmenu/edit/{id}", name="menu_edit")
	 */
	public function menuEditAction($id)
	{
		$data["edit"] = $id;
		return $data;
	}

	/**
	 * @Route("/sadm/manmenu/delete/{id}", name="menu_delete")
	 */
	public function menuDeleteAction($id)
	{
		$data["delete"] = $id;
		return $data;
	}

	/**
	 * @Route("/sadm/manmenu/sort", name="menu_sort")
	 */
	public function menuSortAction()
	{

		$data = $this->get('request')->getContent();
		$array = preg_split("/[&]/", preg_replace("/[menu=]/", "", $data));

		$em = $this->getDoctrine()->getManager();

		$i = 1;
		foreach ($array as $a ) {
			$q = $em->createQuery("UPDATE Mark\MenuBundle\Entity\Menu m SET m.sort = ".$i." WHERE m.sort = ".$a);
			$em->persist($q);
			$i++;
		}

		$em->flush();
		$em->clear();

		return new Response('Done');
	}

}