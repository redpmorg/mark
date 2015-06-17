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
	private $validator;

	public function __construct($em, $validator){
		$this->em = $em;
		$this->validator = $validator;
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
	 * Validate Json Data
	 *
	 * @param  array $data 			Returned jQuery - jSON serialized data
	 * @param  object $entity 		Entity cotainer name
	 * @return array
	 */
	public function validateData($data, $entity)
	{
		$data = parse_str(urldecode($data), $arr);
		$arr = $arr["form"];

		// check (id) existence -- EDIT CASE
		if(array_key_exists("id", $arr)){
			$_id = $arr["id"];
			unset($arr["id"]);
		}

		$violation = "ok";
		foreach($arr as $property => $value){
			$constraintValidationList = $this->validator
			->validatePropertyValue($entity, $property, $value);
			foreach($constraintValidationList as $violations){
				$violation = $violations->getMessage();
			}
		}
		return $violation;
	}
}