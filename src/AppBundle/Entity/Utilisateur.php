<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Notification;

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
        $this->notificationsLues = new ArrayCollection();
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
     * @ORM\ManyToMany(targetEntity="Notification")
     * @ORM\JoinTable(name="utilisateur_lire_notification",
     *      joinColumns={@ORM\JoinColumn(name="utilsateur_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="notification_id", referencedColumnName="id")}
     *      )
     */
    private $notificationsLues;

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
     * Set notificationsLues
     *
     * @param array $notificationsLues
     *
     * @return Utilisateur
     */
    public function setNotificationsLues($notificationsLues)
    {
        $this->notificationsLues = $notificationsLues;

        return $this;
    }

    /**
     * Get notificationsLues
     *
     * @return array
     */
    public function getNotificationsLues()
    {
        return $this->notificationsLues;
    }


    /**
     * Add notificationLue
     *
     * @return Utilisateur
     */
    public function addNotificationsLues($notificationLue)
    {
        $this->notificationsLues[] = $notificationLue;

        return $this;
    }

    /**
     * Add notificationsLue
     *
     * @param \AppBundle\Entity\Notification $notificationsLue
     *
     * @return Utilisateur
     */
    public function addNotificationsLue(\AppBundle\Entity\Notification $notificationsLue)
    {
        $this->notificationsLues[] = $notificationsLue;

        return $this;
    }

    /**
     * Remove notificationsLue
     *
     * @param \AppBundle\Entity\Notification $notificationsLue
     */
    public function removeNotificationsLue(\AppBundle\Entity\Notification $notificationsLue)
    {
        $this->notificationsLues->removeElement($notificationsLue);
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
