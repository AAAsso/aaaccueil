<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Utilisateur;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Monitoring
 *
 * @ORM\Table(name="monitoring")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MonitoringRepository")
 */
class Monitoring
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    private $application;

    /**
     * @var Service[]
     *
     * @ORM\OneToMany(targetEntity="Service", mappedBy="monitoring")
     */
    private $services;

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
     * @return Monitoring
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
     * @return Monitoring
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
     * Set description
     *
     * @param string $description
     *
     * @return Monitoring
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Monitoring
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
     * Add a service to the services
     *
     * @param Service $service
     *
     * @return Monitoring
     */
    public function addServices($service)
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Set services
     *
     * @param Service[] $services
     *
     * @return Monitoring
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return Services
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set application
     *
     * @param Utilisateur $application
     *
     * @return Service
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return Utilisateur
     */
    public function getApplication()
    {
        return $this->application;
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
