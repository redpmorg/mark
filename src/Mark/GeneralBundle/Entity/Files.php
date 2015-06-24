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
 * @ORM\HasLifeCycleCallbacks
 */
class Files
{
	private $temp;

	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="path", type="string", nullable=true)
	 */
	private $path;

	/**
	 * Virtual property
	 *
	 * @Assert\File(maxSize="6000000", mimeTypes = "image/png")
	 *
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
	 * GetAbsolutePath
	 *
	 * @return string path
	 */
	public function getAbsolutePath()
	{
		return null === $this->path
		? null
		: $this->getUploadedRootDir()."/".$this->path;
	}

	/**
	 * GetWebPath
	 *
	 * @return string path
	 */
	public function getWebPath()
	{
		return null === $this->path
		? null
		: $this->getUploadDir().'/'.$this->path;
	}

	// the file should be saved here. in absolute path
	public function getUploadRootDir()
	{
		return "%kernel.root_dir%/../". $this->getUploadDir();
	}

	protected function getUploadDir()
	{
		return 'uploads/';
	}

	/**
	 * Sets file
	 *
	 * @param UploadedFile|null $file
	 */
	public function setFile(File\UploadedFile $file = null)
	{
		$this->file = $file;

		if(isset($this->path)){
			$this->temp = $this->path;
			$this->path = null;
		} else {
			$this->path = 'initial';
		}

	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if(null !== $this->getFile()) {
			$filename = sha1(uniqueid(mt_rand(), true));
			$this->path = $filename.'.'.$this->getFile()->guessExtension();
		}
	}

	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload()
	{
		if(null === $this->getFile()) {
			return;
		}

		$this->getFile()->move(
			$this->getUploadRootDir(),
			$this->path
			);

		if(isset($this->temp)){
			unlink($this->getUploadRootDir().'/'.$this->temp);
			$this->temp = null;
		}
		$this->file = null;
	}

	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload()
	{
		$file = $this->getAbsolutePath();
		if($file) {
			unlink($file);
		}
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


}
