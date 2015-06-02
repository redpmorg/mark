<?php

namespace Mark\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{

	/**
	 * Index Action
	 * @Template("MarkMenuBundle:Default:index.html.twig")
	 */
	public function indexAction()
	{
		//dump( $this->get('security.token_storage')->getToken()->getRoles());

		$data['menu'] = "Meniul dvs";
		return $data;

	}
}
