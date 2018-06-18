<?php

namespace HEI\MargeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChampSupp
 *
 * @ORM\Table(name="champ_supp")
 * @ORM\Entity(repositoryClass="HEI\MargeBundle\Repository\ChampSuppRepository")
 */
class ChampSupp
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
     * @var int
     *
     * @ORM\Column(name="prixPrevu", type="integer")
     */
    private $prixPrevu;

    /**
     * @var int
     *
     * @ORM\Column(name="prixReel", type="integer")
     */
    private $prixReel;

    /**
     * @ORM\ManyToOne(targetEntity="HEI\MargeBundle\Entity\Chantier", inversedBy="champSupps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chantier;

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
     * @return ChampSupp
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
     * Set prixPrevu
     *
     * @param integer $prixPrevu
     *
     * @return ChampSupp
     */
    public function setPrixPrevu($prixPrevu)
    {
        $this->prixPrevu = $prixPrevu;

        return $this;
    }

    /**
     * Get prixPrevu
     *
     * @return int
     */
    public function getPrixPrevu()
    {
        return $this->prixPrevu;
    }

    /**
     * Set prixReel
     *
     * @param integer $prixReel
     *
     * @return ChampSupp
     */
    public function setPrixReel($prixReel)
    {
        $this->prixReel = $prixReel;

        return $this;
    }

    /**
     * Get prixReel
     *
     * @return int
     */
    public function getPrixReel()
    {
        return $this->prixReel;
    }

    /**
     * Set chantier
     *
     * @param \HEI\MargeBundle\Entity\Chantier $chantier
     *
     * @return ChampSupp
     */
    public function setChantier(\HEI\MargeBundle\Entity\Chantier $chantier)
    {
        $this->chantier = $chantier;

        return $this;
    }

    /**
     * Get chantier
     *
     * @return \HEI\MargeBundle\Entity\Chantier
     */
    public function getChantier()
    {
        return $this->chantier;
    }
}
