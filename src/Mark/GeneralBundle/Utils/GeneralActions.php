<?php
/**
 * General Actions
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-11 10:24:59
 * @version $Id$
 */

namespace Mark\GeneralBundle\Utils;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class GeneralActions {


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
	 * Upload files
	 *
	 *  ON WORK
	 * 
	 */
	public function uploadFiles($file)
	{

		$file->upload();

		$this->em->persist($file);
		$this->em->flush();
	}


	/**
	 * Serialize and normalize objects to be used as messages
	 * 
	 * @param array $data 	Array to be serialized as json
	 * @param bool $typeOf 	TRUE - serialize; FALSE - deserialize
	 * @param object $entity The entity name
	 *
	 * @return mixed serialized/deserialized
	 */

	public function serializeMe($data, $typeOf, $entity)
	{

		$encoder = new JsonEncoder();
		$normalizer = new GetSetMethodNormalizer();
		$serializer = new Serializer($normalizer, $encoder);

		if($typeOf) {
			$resp = $serializer->serialize($data, 'json');
		} else {
			$resp = $serializer->deserialize($data, $entity, 'json');
		}

		return $resp;

	}

}