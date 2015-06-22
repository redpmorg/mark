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

	/**
	 * Build menu query results
	 * @param  boolean $all   	If false, generate query for MenuBar else for MenuBrowse
	 * @return array
	 */
	public function generateMenuAction($all = FALSE)
	{

		$this->user = $this->get('user.loggeduser_utils');
		$order = "";

		$em = $this->getDoctrine()->getManager();

		$query_string = "SELECT m FROM MarkMenuBundle:Menu m ";
		if(!$all) {
			$query_string .= "WHERE m.isActive = 1 AND m.roles <= :role ";
		}
		$query_string .= "ORDER BY ";

		$sortCol = $this->user->getUserParameters('m_sortcol');

		if(!$all){
			$query_string .= "m.parent ASC, m.sort ASC ";
		} else {
			if(!$sortCol) {
				$query_string .= "m.parent ASC, m.sort ASC ";
			} else {
				foreach($sortCol as $param => $order) {
					$query_string .= "m." . $param . " " . $order;
				}
			}
		}

		$query = $em->createQuery($query_string);

		if(!$all) {
			$query->setParameters(array("role"=>$this->user->getUserRoleId()));
		}

		if(!$query) {
			throw $this->createNotFoundException('No menu has getted!');
		}

		return $query->getArrayResult();
	}

	/**
	 * Build menu columns
	 *
	 * @return  objects
	 */
	public function generateMenuColumnsAction()
	{
		$em = $this->getDoctrine()->getManager();
		return $em->getClassMetadata('MarkMenuBundle:Menu')->getFieldNames();
	}

}