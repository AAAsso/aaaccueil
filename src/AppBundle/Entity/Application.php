<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 */
class Application
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
     * @Gedmo\Slug(fields={"label"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=550, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=500, unique=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url_directe", type="string", length=1000)
     */
    private $urlDirecte;

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
     * Get slug
     *
     * @return string
     */    
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Application
     */  
    public function setSlug($slug)
    {
        $this->slug = $slug;
        
        return $this;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Application
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
     * Set description
     *
     * @param string $description
     *
     * @return Application
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
     * Set urlDirecte
     *
     * @param string $urlDirecte
     *
     * @return Application
     */
    public function setUrlDirecte($urlDirecte)
    {
        $this->urlDirecte = $urlDirecte;

        return $this;
    }

    /**
     * Get urlDirecte
     *
     * @return string
     */
    public function getUrlDirecte()
    {
        return $this->urlDirecte;
    }

    /**
     * Set createur
     *
     * @param Utilisateur $createur
     *
     * @return Application
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
     * @return Application
     */
    public function setEstPublic($estPublic)
    {
        $this->estPublic = $estPublic;
        
        return $this;
    }
}

