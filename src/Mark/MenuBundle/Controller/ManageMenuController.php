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
use Mark\GeneralBundle\Entity\Files;
use Mark\MenuBundle\Entity\Menu;
use Mark\LoginBundle\Entity\Users;

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

		/* Building the addedit form */
		$menu = new Menu();
		$users = new Users();

		$form = $this->createFormBuilder($menu, array('csrf_protection' => false))
		->add('name', 'text', array('required' => false))
		->add('description', 'text')
		->add('parent', 'integer')
		->add('route', 'text')
		->add('roles', 'choice', array('choices' =>  $users->getAllUsersRoles(), 'required' => false))
		->add('isActive', 'checkbox', array('label' => 'Menu inactive'))
		->getForm();

		$data['form'] = $form->createView();
		$data['form_rulez'] = "";
		$data["form_edit_route"] = "menu_edit";

		return $data;
	}

	/**
	 * Menu Add
	 * @Route("/sadm/manmenu/add", name="menu_add")
	 */
	public function menuAddAction()
	{
		return $this->redirectToRoute('menu_manage');
	}

	/**
	 * Menu Edit
	 * @Route("/sadm/manmenu/edit/{id}", name="menu_edit")
	 */
		public function menuEditAction()
		{
			return $this->redirectToRoute('menu_manage');
		}


	/**
	 * Menu fetch data for edit
	 * @Route("/sadm/manmenu/edit/{id}", name="menu_fetch")
	 */
	public function menuFetchForEditAction($id)
	{
			//construct json

			// construct response
		$response = new Response();
		$response->setContent($json_data);
		$response->headers->set('Content-Type', 'application/json');
		$response->send();
	}

	/**
	 * Menu Delete
	 * @Route("/sadm/manmenu/delete/{id}", name="menu_delete")
	 */
	public function menuDeleteAction($id)
	{
		$entity = "Mark\MenuBundle\Entity\Menu";
		$this->get('general.actions')->delete($entity, 'id', $id);
		$this->get('general.actions')->delete($entity, 'parent', $id);
		return $this->redirectToRoute('menu_manage');
	}

	/**
	 * Sorting rows by jOueryUI sortable
	 * @Route("/sadm/manmenu/rowsort", name="menu_rowsort")
	 */
	public function menuRowSort()
	{
		$data = $this->get('request')->getContent();
		$entityName = "Mark\MenuBundle\Entity\Menu";

		$this->get('general.actions')
		->setSortableRowsOrder($entityName, $data);

		// we don't wanna give him an response :)
		exit;

	}

	/**
	 * Sorting by columns
	 * @Route("/sadm/manmenu/colSort/{param}/{value}", name="menu_colsort")
	 */
	public function menuColSort($param, $value)
	{
		$this->get('user.general_utils')->setUserParameter($param, $value);
		return $this->redirectToRoute('menu_manage');
	}

	/**
	* @Route("/sadm/menmenu/changePict", name="menu_change_picture")
	*/
	public function changeMenuPictureAction()
	{

		$file->setName($this->container->getParameter("app"));

		$this->get('general.actions')->uploadFiles($file);

		return $this->redirectToRoute('menu_manage');
	}
}