<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}

