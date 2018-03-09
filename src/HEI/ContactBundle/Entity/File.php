<?php

namespace HEI\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="HEI\ContactBundle\Repository\FileRepository")
 */
class File
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="HEI\ContactBundle\Entity\Contact")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    private $file;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return File
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set contact
     *
     * @param \HEI\ContactBundle\Entity\Contact $contact
     *
     * @return File
     */
    public function setContact(\HEI\ContactBundle\Entity\Contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \HEI\ContactBundle\Entity\Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload($fileType, $contactId){
        if (null == $this->file) {
            return;
        }

        $name = $this->file->getClientOriginalName();

        $this->file->move($this->getUploadRootDir(), $name);

        $this->nom = $name;
    }

    public function getUploadDir(){
        return 'uploads/'.$this->type;
    }

    protected function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
}
