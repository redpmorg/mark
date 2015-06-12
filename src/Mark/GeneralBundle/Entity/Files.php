<?php

namespace Mark\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Files
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
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 * @Assert\NotBlank
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="path", type="string", nullable=true)
	 */
	private $path;


	/**
	 * Virtual property
	 *
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Image
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set path
	 *
	 * @param string $path
	 * @return
	 */
	public function setPath($path)
	{
		$this->path = $path;

		return $this;
	}

	/**
	 * Get path
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}


	public function getAbsolutePath()
	{
		return null === $this->path
		? null
		: $this->getUploadedRootDir()."/".$this->path;
	}

	public function getWebPath()
	{
		return null === $this->path
		? null
		: $this->getUploadedDir().'/'.$this->path;
	}

	// the file should be saved here. in absolute path
	public function getUploadedRootDir()
	{
		return __DIR__."/../../../../web/". $this->getUploadedDir();
	}

	// get rid of __DIR__ to not fuck of diplaying the files on production
	public function getUploadedDir() {
		return "uploads/";
	}

	/**
	 * Sets file
	 *
	 * @param UploadedFile|null $file
	 */
	public function setFile(File\UploadedFile $file = null)
	{
		$this->file = $file;
	}

	/**
	 * Get file
	 *
	 * @return  UploadedFile
	 */
	public function getFile()
	{
		return $this->file;
	}

	public function upload()
	{
		if(null === $this->getFile()) {
			return;
		}

		$this->getFile()->move(
			$this->getUploadedDir(),
			$this->getFile()->getClientOriginalName()
			);

		$this->path = $this->getFile()->getClientOriginalName();

		$this->file = null;
	}

}
