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
		$t = $this->get('translator');

		// construct parents chioces
		$em = $this->getDoctrine()->getManager();
		$p = $em->getRepository("MarkMenuBundle:Menu")->findByParent('0');
		foreach($p as $val) {
			$parentsName[$val->getId()] = $val->getName();
		}

		// cosntruct form
		$form = $this->createFormBuilder($menu, array(
			'attr' => array(
				'id' => 'addedit-form',
				'class' => 'form-horizontal'
				),
			'csrf_protection' => false
			))
		->add('name', 'text', array(
			'label' => $t->trans('Menu name')
			))
		->add('description', 'text', array(
			'label' => $t->trans('Menu description')
			))
		->add('parent', 'choice', array(
			'required' => false,
			'placeholder' => $t->trans('Choose'),
			'choices' => $parentsName,
			'label' => $t->trans('Submenu parent')
			))
		->add('route', 'text', array(
			'label' => $t->trans('Menu route')
			))
		->add('roles', 'choice', array(
			'choices' => $users->getAllUsersRoles(),
			'label' => $t->trans('Menu permissions')
			))
		->add('isActive', 'checkbox', array(
			'label' => $t->trans('Menu active'),
			'attr' => array(
				'checked' => 'checked'
			)))
		->getForm();

		$data['form'] = $form->createView();
		$data["form_edit_route"] = "menu_edit";

		return $data;
	}

	/**
	 * Menu Add/Edit
	 *
	 * If id - EDIT else ADD
	 *
	 * @Route("/sadm/manmenu/edit", name="menu_edit")
	 */
	public function menuEditAction()
	{

		$data = $this->get('request')->getContent();
		$data = parse_str(urldecode($data), $arr);
		dump($arr);
		exit;

	//	return $this->redirectToRoute('menu_manage');
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
	* @Route("/sadm/menmenu/changePict", name="menu_upload_image")
	*/
	public function changeMenuPictureAction(Response $response)
	{
		$file = new File();
		$file->setName($this->container->getParameter("app"));
		$this->get('general.actions')->uploadFiles($file);
//		return $this->redirectToRoute('menu_manage');
	}
}