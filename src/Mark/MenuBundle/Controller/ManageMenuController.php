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

use Mark\MenuBundle\Controller\MenuController;

class ManageMenuController extends MenuController
{

	/**
	 * Manage Menu Administration
	 * @Route("/sadm/manmenu", name="_manage_menu")
	 * @Template("MarkMenuBundle:Default:manage_menu.html.twig")
	 */
	public function indexAction()
	{


		$data["menu_columns"] = $this->generateMenuColumnsAction();
		$data["menu_rows"] = $this->generateMenuAllAction();

		$data["title"] = "Menu Manager";

		return $data;
	}

}