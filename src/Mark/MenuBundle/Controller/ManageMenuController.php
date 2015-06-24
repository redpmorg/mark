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

use Mark\MenuBundle\Controller\MenuController;
use Mark\GeneralBundle\Entity\Files;
use Mark\MenuBundle\Entity\Menu;
use Mark\LoginBundle\Entity\Users;

class ManageMenuController extends MenuController
{
	/**
	 * Menu Browse
	 *
	 * @Route("/sadm/manmenu/", name="menu_manage")
	 * @Template("MarkMenuBundle:Default:menu_browse.html.twig")
	 */
	public function menuManageAction()
	{
		$data["menu_columns"] = $this->generateMenuColumnsAction();
		$data["menu_rows"] = $this->generateMenuAction($all = true);
		$data["title"] = "Menu Manager";

		/* Building the addedit form */
		$menu = new Menu();
		$users = new Users();
		$t = $this->get('translator');

		// construct parents chioces
		$em = $this->getDoctrine()->getManager();
		$p = $em->getRepository(get_class($menu))->findByParent('0');
		foreach($p as $val) {
			$parentsName[$val->getId()] = $val->getName();
		}

		// Construct form to be injected on modal add/edit
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
			'required' => false,
			'label' => $t->trans('Menu route')
			))
		->add('roles', 'choice', array(
			'choices' => $users->getAllUsersRoles(),
			'label' => $t->trans('Menu link')
			))
		->add('isActive', 'checkbox', array(
			'label' => $t->trans('Menu'),
			'attr' => array('checked' => true)
			))
		->add('sort', 'hidden', array(
			'data' => 1))
		->getForm();

		$data['form'] = $form->createView();

		//Take care about all details
		$data['modal_edit_title'] = "Edit menu";
		$data['modal_add_title'] = "Add menu";

		$data['modal_delete_id'] = "menuDeleteModal";
		$data['modal_delete_title'] = 'Delete menu';
		$data['modal_delete_message'] = "Deleted records can not be restored!";
		$data['modal_delete_route'] = "menu_delete";

		$data['modal_image_id'] = "modalImageId";

		$data['route_edit_fetch'] = "menu_fetch";
		$data['route_edit_action'] = "menu_edit";
		$data['route_add_action'] = "menu_add";
		$data['route_image_action'] = "menu_upload_image";

		$data['sortable_container'] = "tbody";
		$data['sortable_key'] = "srt";
		$data['sortable_route'] = 'menu_rowsort';

		return $data;
	}

	/**
	 * Menu Fetch Data for Edit
	 *
	 * @Route("/sadm/manmenu/fetch/{id}", name="menu_fetch")
	 */
	public function menuFetchEditAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			"SELECT m
			FROM MarkMenuBundle:Menu m
			WHERE m.id = ?1"
			)->setParameter(1, $id);
		$menu = $query->getArrayResult();
		echo json_encode($menu[0]);

		exit;
	}


	/**
	 * Menu Edit && Validate
	 *
	 * @Route("/sadm/manmenu/edit", name="menu_edit")
	 */
	public function menuEditAction()
	{
		$entity = new Menu();

		$request = $this->get('request');
		$content = $request->getContent();
		parse_str(urldecode($content), $arr);
		$arr = $arr['form'];
		$this->get('validator')->

		exit;
	}

	// {
	// 	$entity = new Menu();
	// 	$content = $this->get('request')->getContent();
	// 	$ga = $this->get('general.actions');
	// 	parse_str(urldecode($content), $arr);
	// 	$arr = $arr['form'];

	// 	$validate_error = $ga->validateData($entity, $arr);

	// 	if('ok' !== $validate_error) {
	// 		exit($validate_error);
	// 	}

	// 	if(array_key_exists('id', $arr)) {
	// 		$ga->persistEditedData($entity, $arr);
	// 	}

	// 	exit;
	// }

	/**
	 * Menu Add
	 *
	 * @Route("/sadm/manmenu/add", name="menu_add")
	 */
	public function menuAddAction()
	{
		$entity = new Menu();
		$data = $this->get('request')->getContent();
		parse_str(urldecode($content), $arr);
		$arr = $arr['form'];

		$ga = $this->get('general.actions')->persistAddedData($entity, $arr);

		return $this->redirectToRoute('menu_manage');
	}


	/**
	 * Menu Delete
	 *
	 * @Route("/sadm/manmenu/delete/{id}", name="menu_delete")
	 */
	public function menuDeleteAction($id)
	{
		$entity = new Menu();
		$this->get('general.actions')->persistDeletedData($entity, 'id', $id);
		$this->get('general.actions')->persistDeletedData($entity, 'parent', $id);

		return $this->redirectToRoute('menu_manage');
	}

	/**
	 * Sorting rows by jOueryUI sortable
	 *
	 * @Route("/sadm/manmenu/rowsort", name="menu_rowsort")
	 */
	public function menuRowSort()
	{
		$data = $this->get('request')->getContent();
		$entityName = "Mark\MenuBundle\Entity\Menu";
		$this->get('general.actions')->setSortableRowsOrder($entityName, $data);

		exit;
	}

	/**
	 * Sorting by columns [toggle order]
	 *
	 * @Route("/sadm/manmenu/colSort/{param}/{value}", name="menu_colsort")
	 *
	 * @param  string $param 	Parameter name
	 * @param  array  $value    Parameter value
	 */
	public function menuColSort($param, $value)
	{
		$order = "ASC";
		$p = $this->get('user.loggeduser_utils')->getUserParameters($param);
		if($p && array_key_exists($value, $p)){
			$order = ("ASC" == $p[$value]) ? "DESC" : "ASC";
		}
		$this->get('user.general_utils')->setUserParameter($param, array($value => $order));

		return $this->redirectToRoute('menu_manage');
	}

	/**
	* Change menu picture/thumbnail
	*
	* @Route("/sadm/manmenu/changePict", name="menu_upload_image")
	*/
	public function changeMenuPictureAction()
	{
		$request = $this->get('request');
		$files = $request->files->get('form');
		$files = $files['file'];

		$file = new Files();
		$file->upload($files);
		$err = $this->get('validator')->validate($file);

		if(count($err) != 0){
			$err = (string) $err;
			exit($err);
		}


		$em = $this->getDoctrine()->getManager();
		$em->persist($file);
		$em->flush();
		$em->clear();

		return $this->redirectToRoute('menu_manage');
	}
}