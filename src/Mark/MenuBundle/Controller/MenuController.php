<?php

namespace Mark\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Mark\MenuBundle\Entity\Menu;

class MenuController extends Controller
{

	/**
	 * Index Action
	 * @Template("MarkMenuBundle:Default:index.html.twig")
	 */
	public function indexAction()
	{

		$user = $this->get('user.loggeduser_utils');

		$data["user_fname"] = $user->getUserFirstname();
		$data["user_role"]  = $user->getUserRoleName();
		$data["app"] = $this->container->getParameter("app");


		$data['menu'] = $this->generateMenuAction($user->getUserRoleId());

		return $data;

	}

	public function generateMenuAction($user_role_id)
	{

		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			"SELECT m
			FROM MarkMenuBundle:Menu m
			WHERE m.isActive = 1
			AND m.roles <= :role
			ORDER BY m.parent ASC, m.sort ASC
			");
		$query->setParameters(array("role"=>$user_role_id));

		return $query->getResult();

	}



}
