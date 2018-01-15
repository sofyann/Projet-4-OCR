<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_commande", type="datetime")
     */
    private $dateDeCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_visite", type="datetime")
     */
    private $dateDeVisite;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_total", type="integer")
     */
    private $prixTotal;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Commanditaire", inversedBy="commandes")
     */
    private $commanditaire;

    /**
     * @var string
     *
     * @ORM\Column(name="code_reservation", type="string", length=255, unique=true)
     */
    private $codeReservation;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Billet", mappedBy="commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billets;

    /**
     * @return mixed
     */
    public function getBillets()
    {
        return $this->billets;
    }




    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

    /**
     * @ORM\Column(name="duree", type="string")
     */
    private $duree;

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param mixed $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
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
     * Set dateDeCommande
     *
     * @param \DateTime $dateDeCommande
     *
     * @return Commande
     */
    public function setDateDeCommande($dateDeCommande)
    {
        $this->dateDeCommande = $dateDeCommande;

        return $this;
    }

    /**
     * Get dateDeCommande
     *
     * @return \DateTime
     */
    public function getDateDeCommande()
    {
        return $this->dateDeCommande;
    }

    /**
     * Set dateDeVisite
     *
     * @param \DateTime $dateDeVisite
     *
     * @return Commande
     */
    public function setDateDeVisite($dateDeVisite)
    {
        $this->dateDeVisite = $dateDeVisite;

        return $this;
    }

    /**
     * Get dateDeVisite
     *
     * @return \DateTime
     */
    public function getDateDeVisite()
    {
        return $this->dateDeVisite;
    }

    /**
     * Set prixTotal
     *
     * @param integer $prixTotal
     *
     * @return Commande
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get prixTotal
     *
     * @return int
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * @return mixed
     */
    public function getCommanditaire()
    {
        return $this->commanditaire;
    }

    /**
     * @param mixed $commanditaire
     */
    public function setCommanditaire($commanditaire)
    {
        $this->commanditaire = $commanditaire;
    }



    /**
     * Set codeReservation
     *
     * @param string $codeReservation
     *
     * @return Commande
     */
    public function setCodeReservation($codeReservation)
    {
        $this->codeReservation = $codeReservation;

        return $this;
    }

    /**
     * Get codeReservation
     *
     * @return string
     */
    public function getCodeReservation()
    {
        return $this->codeReservation;
    }
}

