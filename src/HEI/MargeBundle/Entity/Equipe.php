<?php

namespace HEI\MargeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity(repositoryClass="HEI\MargeBundle\Repository\EquipeRepository")
 */
class Equipe
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
     * @ORM\Column(name="nom", type="string", length=100, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="membre1", type="string", length=255)
     */
    private $membre1;

    /**
     * @var string
     *
     * @ORM\Column(name="membre2", type="string", length=255)
     */
    private $membre2;

    /**
     * @var string
     *
     * @ORM\Column(name="membre3", type="string", length=255)
     */
    private $membre3;


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
     * @return Equipe
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
     * Set membre1
     *
     * @param string $membre1
     *
     * @return Equipe
     */
    public function setMembre1($membre1)
    {
        $this->membre1 = $membre1;

        return $this;
    }

    /**
     * Get membre1
     *
     * @return string
     */
    public function getMembre1()
    {
        return $this->membre1;
    }

    /**
     * Set membre2
     *
     * @param string $membre2
     *
     * @return Equipe
     */
    public function setMembre2($membre2)
    {
        $this->membre2 = $membre2;

        return $this;
    }

    /**
     * Get membre2
     *
     * @return string
     */
    public function getMembre2()
    {
        return $this->membre2;
    }

    /**
     * Set membre3
     *
     * @param string $membre3
     *
     * @return Equipe
     */
    public function setMembre3($membre3)
    {
        $this->membre3 = $membre3;

        return $this;
    }

    /**
     * Get membre3
     *
     * @return string
     */
    public function getMembre3()
    {
        return $this->membre3;
    }
}

