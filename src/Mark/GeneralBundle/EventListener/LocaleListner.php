<?php
/**
 * Mark Exception Listner for handeling the defaultLocale from request
 * @authors Leonard Lepadatu (leonardlepadatu@yahoo.com)
 * @date    2015-06-06 18:37:55
 * @version $Id$
 */

namespace Mark\GeneralBundle\EventListner;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KErnelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListner implements EventSubscriberInterface
{

	private $defaultLocale;

	public function __construct($defaultLocale)
	{
		$this->defaultLocale = $defaultLocale;
	}

}