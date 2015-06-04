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


class ManageMenuController extends Controller
{

	/**
	 * Manage Menu Administration
	 * @Route("/sadm/manmenu", name="_manage_menu")
	 * @Template("MarkMenuBundle::manage_menu.html.twig")
	 */
	public function indexAction()
	{
		return 1;
	}

}