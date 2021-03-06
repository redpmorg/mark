<?php
/**
 * General Actions
 * @authors Leonard LEPADATU (lepadatu.leonard-ext@groupehn.com)
 * @date    2015-06-11 10:24:59
 * @version $Id$
 */

namespace Mark\GeneralBundle\Utils;

class GeneralActions {

	private $em;
	private $validator;

	public function __construct($em, $validator){
		$this->em = $em;
		$this->validator = $validator;
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
	public function uploadFiles($entity, $file)
	{

		$this->validator->validate($file);

	}

	/**
	 * Validate Json Data
	 *
	 * @param  array $arr 			Form returned array of data
	 * @param  object $entity 		Entity name
	 * @return array
	 */
	public function validateData($entity, $arr)
	{
		if(array_key_exists("id", $arr)){
			$_id = $arr["id"];
			unset($arr["id"]);
		}
		$violation = "ok";
		foreach($arr as $property => $value){
			$constraintValidationList =	$this->validator
			->validatePropertyValue(
				$entity,
				$property,
				$value
				);
			foreach($constraintValidationList as $violations){
				$violation = $violations->getMessage();
			}
		}

		return $violation;
	}

	/**
	 * PersistEditedData
	 *
	 * @param object $entity 	Entity to persist
	 * @param array $arr 		Array data to be edited
	 */

	public function persistEditedData($entity, $arr)
	{
		if(array_key_exists("id", $arr)){
			$_id = $arr["id"];
			unset($arr["id"]);
		}
		$query = "UPDATE " . get_class($entity) ." e SET ";
		foreach( $arr as $property => $value ){
			$query .= "e." .$property. "='" .$value ."' ";
		}
		$query .="WHERE e.id=".$_id;
		$this->em->createQuery($query)->execute();
		$this->em->clear();
	}

	/**
	 * PersistAddedData
	 *
	 * @param obj $entity 	Entity to persist
	 * @param array $arr 	Array data to be added
	 */

	public function persistAddedData($entity, $arr)
	{
		foreach($arr as $met => $val ) {
			$method_name = "set" . ucwords($met);
			$entity->{$method_name}($val);
		}
		$this->em->persist($entity);
		$this->em->flush();
		$this->em->clear();
	}

	/**
	 * PersistDeletedData
	 *
	 * @param
	 */

	public function persistDeletedData($entity, $property, $id)
	{
		$query = "DELETE ";
		$query .= get_class($entity)." e ";
		$query .= "WHERE e.{$property} = ?1 ";
		$this->em->createQuery($query)
				->setParameter(1, $id)
				->execute();
		$this->em->clear();
	}

}