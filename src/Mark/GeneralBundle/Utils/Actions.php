<?php
/**
 * General Actions
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-11 10:24:59
 * @version $Id$
 */

namespace Mark\GeneralBundle\Utils;

class Actions {


	private $em;

	public function __construct($em){
		$this->em = $em;
	}

	public function delete($entity, $property, $id)
	{
		$query = "DELETE ";
		$query .= "{$entity} e ";
		$query .= "WHERE e.{$property} = ?1 ";

		$this->em->createQuery($query)
		->setParameter(1, $id)
		->execute();

		$this->em->clear();
	}

	/**
	 * Persist jQueryUI sortable row order
	 *
	 * @param string 	$entityName  	entity name with complete namespace
	 * @param json 		$data 			data from request
	 */
	public function setSortableRowsOrder($entityName, $data)
	{
		$array = preg_split("/[&]/", preg_replace("/[srt=]/", "", $data));

		$order = 1;
		foreach($array as $id) {
			$this->em->createQuery(
				'UPDATE '.
				$entityName.
				' m set m.sort = '
				.($order*777)
				.' where m.id = '
				.$id )->execute();
			$order++;
		}

		$this->em->clear();
	}

	/**
	 * Upload fils
	 */
	public function uploadFiles($file)
	{

		$file->upload();

		$this->em->persist($file);
		$this->em->flush();
	}

}