<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Utilisateur;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\Column(name="label", type="string", length=255, unique=true)
     */
    private $label;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"label"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=500, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=500, unique=true)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var bool
     *
     * @ORM\Column(name="estSurAccueil", type="boolean")
     */
    private $estSurAccueil;

    /**
     * @var Monitoring
     *
     * @ORM\ManyToOne(targetEntity="Monitoring", inversedBy="services")
     * @ORM\JoinColumn(name="monitoring_id", referencedColumnName="id")
     */
    private $monitoring;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(name="createur_id", referencedColumnName="id")
     */
    private $createur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="est_public", type="boolean")
     */
    private $estPublic;

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
     * Set label
     *
     * @param string $label
     *
     * @return Service
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Service
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Service
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Service
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set estSurAccueil
     *
     * @param boolean $estSurAccueil
     *
     * @return Service
     */
    public function setEstSurAccueil($estSurAccueil)
    {
        $this->estSurAccueil = $estSurAccueil;

        return $this;
    }

    /**
     * Get estSurAccueil
     *
     * @return bool
     */
    public function getEstSurAccueil()
    {
        return $this->estSurAccueil;
    }

    /**
     * Set monitoring
     *
     * @param Monitoring $monitoring
     *
     * @return Service
     */
    public function setMonitoring($monitoring)
    {
        $this->monitoring = $monitoring;

        return $this;
    }

    /**
     * Get monitoring
     *
     * @return Monitoring
     */
    public function getMonitoring()
    {
        return $this->monitoring;
    }

    /**
     * Set createur
     *
     * @param Utilisateur $createur
     *
     * @return Service
     */
    public function setCreateur($createur)
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * Get createur
     *
     * @return Utilisateur
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Get estPublic
     *
     * @return boolean
     */
    public function getEstPublic()
    {
        return $this->estPublic;
    }

    /**
     * Set estPublic
     *
     * @param boolean $estPublic
     *
     * @return Service
     */
    public function setEstPublic($estPublic)
    {
        $this->estPublic = $estPublic;

        return $this;
    }
}
