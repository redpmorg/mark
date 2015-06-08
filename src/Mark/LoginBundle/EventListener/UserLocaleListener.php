<?php
/**
 * UserLocaleListner
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-08 10:49:54
 * @version $Id$
 */
namespace Mark\LoginBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserLocaleListener
{
	private $session;

	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	public function onInteractiveLogin(InteractiveLoginEvent $event)
	{
		$user = $event->getAuthenticationToken()->getUser();
		if(null !== $user->getLocale()){
			$this->session->set("_locale", $user->getLocale());
		}
	}

}

