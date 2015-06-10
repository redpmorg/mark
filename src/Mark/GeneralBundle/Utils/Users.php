<?php

/**
 * General Utils
 *
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-10 17:08:31
 * @version $Id$
 */

namespace Mark\GeneralBundle\Utils;

class Users
{

	public function __construct($em, $u)
	{
		$this->em = $em;
		$this->u = $u;
	}

	/**
	 * Set user parameter
	 * @param string $param [description]
	 * @param string $value [description]
	 */
	public function setUserParameter($param, $value)
	{
		$loggedUserId = $this->u->getUserId();

		// search if $param exists
		$userParam = $this->em->getRepository("MarkLoginBundle:Users")
		->findOneById($loggedUserId)->getUserParam();

		$userParamArray[$param] = $value;
		$param = serialize($userParamArray);

		$this->em->createQuery("
			UPDATE Mark\LoginBundle\Entity\Users u
			SET u.user_param = :p
			WHERE u.id = :i
			")
		->setParameters(array(
			"p" => $param,
			"i" => $loggedUserId
			))
		->execute();

		$this->em->flush();
	}
}
