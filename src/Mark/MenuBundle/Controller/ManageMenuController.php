<?php
/**
 * Menu Administrate Form
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-04 15:16:41
 * @version $Id$
 */

namespace Mark\MenuBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Mark\MenuBundle\Controller\MenuController;
use Mark\GeneralBundle\Utils\Users AS UsersUtils;

class ManageMenuController extends MenuController
{

	/**
	 * Menu Browse
	 * @Route("/sadm/manmenu/", name="menu_manage")
	 * @Template("MarkMenuBundle:Default:menu_browse.html.twig")
	 */
	public function menuManageAction()
	{
		$data["menu_columns"] = $this->generateMenuColumnsAction();
		$data["menu_rows"] = $this->generateMenuAction();

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
	 * Menu Delete
	 * @Route("/sadm/manmenu/delete/{id}", name="menu_delete")
	 */
	public function menuDeleteAction($id)
	{
		$data["delete"] = $id;
		return $data;
	}

	/**
	 * Sorting rows by jOueryUI sortable
	 * @Route("/sadm/manmenu/rowsort", name="menu_rowsort")
	 */
	public function menuRowSortAction()
	{
		$data = $this->get('request')->getContent();
		$array = preg_split("/[&]/", preg_replace("/[srt=]/", "", $data));
		$em = $this->getDoctrine()->getManager();

		$order = 1;
		foreach($array as $id) {
			$em->createQuery('
				UPDATE Mark\MenuBundle\Entity\Menu m set m.sort = '
				.$order
				.' where m.id = '
				.$id )->execute();
			$order++;
		}
		$em->clear();

		return new Response('Done');
	}

	/**
	 *  !!!!!!!!   EXTERNALIZEAZA ASTA IN GENERAL BUNDLE ( trimite numele param si data) !!!!!
	 * Sorting by columns
	 * @Route("/sadm/manmenu/colSort/{param}/{value}", name="menu_colsort")
	 */
	public function menuColSort($param, $value)
	{

		$this->get('user.general_utils')->setUserParameter($param, $value);

		return $this->redirectToRoute('menu_manage');
	}

}