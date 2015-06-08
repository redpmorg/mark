<?php

namespace Mark\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Mark\MenuBundle\Entity\Menu;

class MenuController extends Controller
{

	private $user;

	/**
	 * Index Action
	 * @Template("MarkMenuBundle:Default:index.html.twig")
	 */
	public function indexAction()
	{
		$this->user = $this->get('user.loggeduser_utils');

		$data["user_fname"] = $this->user->getUserFirstname();
		$data["user_role"]  = $this->user->getUserRoleName();
		$data["user_roleid"] = $this->user->getUserRoleId();
		$data["app"] = $this->container->getParameter("app");

		$data['menu'] = $this->generateMenuAction();

		return $data;

	}


	// $all is true only for browsing in menuManagerAction
	// and return all tre records
	public function generateMenuAction($all = false)
	{

		$this->user = $this->get('user.loggeduser_utils');
		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
			"SELECT m
			FROM MarkMenuBundle:Menu m
			WHERE m.isActive = 1
			AND m.roles <= :role
			ORDER BY m.parent ASC, m.sort ASC
			");

		if(isset($how)) {
			$query = $em->createQuery(
				"SELECT m
				FROM MarkMenuBundle:Menu m
				ORDER BY m.parent ASC, m.sort ASC
				");
		}

		$query->setParameters(array("role"=>$this->user->getUserRoleId()));

		if(!$query) {
			throw $this->createNotFoundException('No menu has getted!');
		}

		return $query->getArrayResult();

	}

	// public function generateMenuAllAction()
	// {
	// 	$this->user = $this->get('user.loggeduser_utils');
	// 	$em = $this->getDoctrine()->getManager();

	// 	$query = $em->createQuery(
	// 		"SELECT m
	// 		FROM MarkMenuBundle:Menu m
	// 		ORDER BY m.parent ASC, m.sort ASC
	// 		");

	// 	if(!$query) {
	// 		throw $this->createNotFoundException('No menu has getted!');
	// 	}
	// 	return $query->getArrayResult();

	// }

	public function generateMenuColumnsAction()
	{
		$em = $this->getDoctrine()->getManager();
		$metadata = $em->getClassMetadata('MarkMenuBundle:Menu')->getFieldNames();

		return $metadata;

	}

}