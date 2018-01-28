<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Notification;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurRepository")
 */
class Utilisateur implements \Serializable
{
    public function __construct()
    {
        $this->notificationsNonLues = new ArrayCollection();
    }

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
     * @ORM\Column(name="pseudo", type="string", length=200, unique=true)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=500)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=500, nullable=true)
     */
    private $avatar;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Notification", inversedBy="utilisateursConcernes", fetch="EAGER")
     * @ORM\JoinTable(name="utilisateur_notification_non_lue",
     *      joinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="notification_id", referencedColumnName="id")}
     *      )
     */
    private $notificationsNonLues;

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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Utilisateur
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Utilisateur
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     *
     * @return Utilisateur
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Utilisateur
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set notificationsNonLues
     *
     * @param array $notificationsNonLues
     *
     * @return Utilisateur
     */
    public function setNotificationsNonLues($notificationsNonLues)
    {
        $this->notificationsNonLues = $notificationsNonLues;

        return $this;
    }

    /**
     * Get notificationsNonLues
     *
     * @return array
     */
    public function getNotificationsNonLues()
    {
        return $this->notificationsNonLues;
    }

    /**
     * Add notificationsNonLue
     *
     * @param \AppBundle\Entity\Notification $notificationsNonLues
     *
     * @return Utilisateur
     */
    public function addNotificationsNonLues(\AppBundle\Entity\Notification $notificationsNonLues)
    {
        $this->notificationsNonLues[] = $notificationsNonLues;

        return $this;
    }

    /**
     * Remove notificationsNonLue
     *
     * @param \AppBundle\Entity\Notification $notificationsNonLues
     */
    public function removeNotificationsNonLues(\AppBundle\Entity\Notification $notificationsNonLues)
    {
        $this->notificationsNonLues->removeElement($notificationsNonLues);
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->pseudo,
            $this->mdp,
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->pseudo,
            $this->mdp,
            // $this->salt
        ) = unserialize($serialized);
    }
}
