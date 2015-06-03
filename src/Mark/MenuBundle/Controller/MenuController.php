<?php

namespace Mark\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Mark\LoginBundle\Controller\UserUtilsController;
use Mark\MenuBundle\Entity\Menu;


class MenuController extends Controller
{

	/**
	 * Index Action
	 * @Template("MarkMenuBundle:Default:index.html.twig")
	 */
	public function indexAction()
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();

		$data["user_fname"] = $user->getFirstname();
		$data["user_role"] = $user->getRoles();
		$data['menu'] = $this->generateMenuAction();

		return $data;

	}

	public function generateMenuAction()
	{

		$repository = $this->getDoctrine()->getRepository('MarkMenuBundle:Menu');

		// get all active menus
		$raw_menu = $repository->findBy(array("isActive" => 1));

		// get current RoleId
		$uu = new UserUtilsController;
		$roleId = $uu->indexAction();

		return $raw_menu;
	}



}
