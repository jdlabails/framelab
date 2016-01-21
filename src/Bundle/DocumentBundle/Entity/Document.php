<?php

namespace Framelab\Bundle\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Framelab\Bundle\UserBundle\Entity\User;

/**
 * Document.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Framelab\Bundle\DocumentBundle\Entity\DocumentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=500)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=750)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=10)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="Framelab\Bundle\UserBundle\Entity\User", inversedBy="documents")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $owner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $tempFilename;

    /**
     * @var string
     */
    private $uploadRootDir;

    /**
     * @var string
     */
    private $uploadDir;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set $filename.
     *
     * @param string $filename
     *
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set extension.
     *
     * @param string $extension
     *
     * @return Document
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set size.
     *
     * @param int $size
     *
     * @return Document
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set owner.
     *
     * @param User $owner
     *
     * @return Document
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner.
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set file.
     *
     * @param UploadedFile $file
     *
     * @return Document
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if (!is_null($this->getFilename())) {
            //backup filename
            $this->setTempFilename($this->getFilename());
            //reinit filename
            $this->setFilename(null);
        }

        return $this;
    }

    /**
     * Get file.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set tempFilename.
     *
     * @return Document
     */
    public function setTempFilename($tempFilename)
    {
        $this->tempFilename = $tempFilename;

        return $this;
    }

    /**
     * Get tempFilename.
     *
     * @return string
     */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }

    /**
     * Set uploadDir.
     *
     * @param string $uploadDir
     *
     * @return Document
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    /**
     * Get uploadDir.
     *
     * @return string
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * Set uploadRootDir.
     *
     * @param string uploadRootDir
     *
     * @return Document
     */
    public function setUploadRootDir($uploadRootDir)
    {
        $this->uploadRootDir = $uploadRootDir;

        return $this;
    }

    /**
     * Get uploadRootDir.
     *
     * @return string
     */
    public function getUploadRootDir()
    {
        return $this->uploadRootDir.$this->getUploadDir();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (is_null($this->getFile())) {
            return;
        }
        //affect uploader data
        $this->setFilename($this->getFile()->getClientOriginalName());
        $this->setExtension($this->getFile()->guessExtension());
        $this->setSize($this->getFile()->getClientSize());
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (is_null($this->getFile())) {
            return;
        }
        //remove file if already exists
        if (!is_null($this->getTempFilename())) {
            $oldFile = $this->getUploadRootDir().'/'.$this->getId().'_'.$this->getTempFilename();
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        //move file
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getId().'_'.$this->getFilename()
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        //use tempfilename
        $this->setTempFilename($this->getWebPath(true));
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        //use tempfilename because no id available
        if (file_exists($this->getTempFilename())) {
            unlink($this->getTempFilename());
        }
    }

    /**
     * @param bool $rootScope
     *
     * @return string
     */
    public function getWebPath($rootScope = false)
    {
        $path = '';
        //scope
        if ($rootScope) {
            $path .= $this->getUploadRootDir();
        } else {
            $path .= $this->getUploadDir();
        }
        //append
        $path .= '/'.$this->getId().'_'.$this->getFilename();
        //return
        return $path;
    }
}
