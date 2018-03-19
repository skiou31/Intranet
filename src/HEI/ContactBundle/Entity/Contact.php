<?php

namespace HEI\ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use HEI\UserBundle\Entity\User;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="HEI\ContactBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="civilite", type="string", length=8)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="codePostal", type="integer")
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=100)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=10)
     * @Assert\Length(min=10, max=10)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjout", type="date")
     * @Assert\Type(type="\DateTime")
     */
    private $dateAjout;

    /**
     * @var string
     *
     * @ORM\Column(name="origine", type="string", length=50)
     */
    private $origine;

    /**
     * @var string
     *
     * @ORM\Column(name="origineDetail", type="string", length=50, nullable=true)
     */
    private $origineDetail;

    /**
     * @var string
     *
     * @ORM\Column(name="parrain", type="string", length=50, nullable=true)
     */
    private $parrain;

    /**
     * @var string
     *
     * @ORM\Column(name="projet", type="string", length=50)
     */
    private $projet;

    /**
     * @var string
     *
     * @ORM\Column(name="typeMaison", type="string", length=50, nullable=true)
     */
    private $typeMaison;

    /**
     * @var int
     *
     * @ORM\Column(name="anneeConstruction", type="integer", nullable=true)
     * @Assert\Length(min=4, max=4)
     */
    private $anneeConstruction;

    /**
     * @var int
     *
     * @ORM\Column(name="typeContact", type="integer")
     */
    private $typeContact;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="HEI\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commercial;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity="HEI\ContactBundle\Entity\File", mappedBy="contact")
     */
    private $files;

    /**
     * Contact constructor.
     * @param \DateTime $dateAjout
     */
    public function __construct()
    {
        $this->dateAjout = new \DateTime();
        $this->typeContact = 0;
        $this->files = new ArrayCollection();
    }


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
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Contact
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Contact
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Contact
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Contact
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Contact
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Contact
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Contact
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Contact
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set origine
     *
     * @param string $origine
     *
     * @return Contact
     */
    public function setOrigine($origine)
    {
        $this->origine = $origine;

        return $this;
    }

    /**
     * Get origine
     *
     * @return string
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * Set origineDetail
     *
     * @param string $origineDetail
     *
     * @return Contact
     */
    public function setOrigineDetail($origineDetail)
    {
        $this->origineDetail = $origineDetail;

        return $this;
    }

    /**
     * Get origineDetail
     *
     * @return string
     */
    public function getOrigineDetail()
    {
        return $this->origineDetail;
    }

    /**
     * Set parrain
     *
     * @param mixed $parrain
     *
     * @return Contact
     */
    public function setParrain($parrain)
    {
        $this->parrain = $parrain;

        return $this;
    }

    /**
     * Get parrain
     *
     * @return mixed
     */
    public function getParrain()
    {
        return $this->parrain;
    }

    /**
     * Set projet
     *
     * @param string $projet
     *
     * @return Contact
     */
    public function setProjet($projet)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return string
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * Set typeMaison
     *
     * @param string $typeMaison
     *
     * @return Contact
     */
    public function setTypeMaison($typeMaison)
    {
        $this->typeMaison = $typeMaison;

        return $this;
    }

    /**
     * Get typeMaison
     *
     * @return string
     */
    public function getTypeMaison()
    {
        return $this->typeMaison;
    }

    /**
     * Set anneeConstruction
     *
     * @param integer $anneeConstruction
     *
     * @return Contact
     */
    public function setAnneeConstruction($anneeConstruction)
    {
        $this->anneeConstruction = $anneeConstruction;

        return $this;
    }

    /**
     * Get anneeConstruction
     *
     * @return int
     */
    public function getAnneeConstruction()
    {
        return $this->anneeConstruction;
    }

    /**
     * Set typeContact
     *
     * @param integer $typeContact
     *
     * @return Contact
     */
    public function setTypeContact($typeContact)
    {
        $this->typeContact = $typeContact;

        return $this;
    }

    /**
     * Get typeContact
     *
     * @return int
     */
    public function getTypeContact()
    {
        return $this->typeContact;
    }

    /**
     * Set commercial
     *
     * @param string $commercial
     *
     * @return Contact
     */
    public function setCommercial(User $commercial)
    {
        $this->commercial = $commercial;

        return $this;
    }

    /**
     * Get commercial
     *
     * @return string
     */
    public function getCommercial()
    {
        return $this->commercial;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Contact
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function addFile(File $file)
    {
        $this->files[] = $file;

        $file->setContact($this);
    }

    public function removeFile(File $file)
    {
        $this->files->removeElement($file);
    }

    public function getFiles()
    {
        return $this->files;
    }
}
