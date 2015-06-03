<?php

namespace Mark\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Menu
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;


	/**
	 * @var integer
	 * @ORM\Column(name="parent_id", type="integer")
	 */
	private $parent_id;

	/**
	 * @var string
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(name="description", type="string", length=255)
	 */
	private $description;

	/**
	 * @var integer
	 * @ORM\Column(name="parent", type="integer")
	 */
	private $parent;

	/**
	 * @var string
	 * @ORM\Column(name="route", type="string", length=255)
	 */
	private $route;

	/**
	 * @var boolean
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;

	/**
	 * @var integer
	 * @ORM\Column(name="roles", type="integer")
	 */
	private $roles;


	/**
	 * @var integer
	 * @ORM\Column(name="sort", type="integer")
	 */
	private $sort;



	/**
	 * Get id
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Set name
	 * @param string $name
	 * @return Menu
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set description
	 * @param string $description
	 * @return Menu
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set parent
	 * @param integer $parent
	 * @return Menu
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;

		return $this;
	}

	/**
	 * Get parent
	 * @return integer
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * Set route
	 * @param string $route
	 * @return Menu
	 */
	public function setRoute($route)
	{
		$this->route = $route;

		return $this;
	}

	/**
	 * Get route
	 * @return string
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * Set isActive
	 * @param boolean $isActive
	 * @return Menu
	 */
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;

		return $this;
	}

	/**
	 * Get isActive
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->isActive;
	}

	/**
	 * Set roles
	 * @param integer $roles
	 * @return Menu
	 */
	public function setRoles($roles)
	{
		$this->roles = $roles;

		return $this;
	}

	/**
	 * Get roles
	 * @return integer
	 */
	public function getRoles()
	{
		return $this->roles;
	}

	/**
	* Set sort
	* @return integer
	*/
	public function setSort($sort)
	{
		$this->sort = $sort;
		return $this->sort;
	}



	/**
	 * Get sort
	 *
	 * @return integer
	 */
	public function getSort()
	{
		return $this->sort;
	}

	/**
	 * Set parent_id
	 *
	 * @param integer $parentId
	 * @return Menu
	 */
	public function setParentId($parentId)
	{
		$this->parent_id = $parentId;

		return $this;
	}

	/**
	 * Get parent_id
	 *
	 * @return integer
	 */
	public function getParentId()
	{
		return $this->parent_id;
	}
}
