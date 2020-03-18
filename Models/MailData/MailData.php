<?php

namespace   MailCampaignsConnector\Models\MailData;

use Symfony\Component\Validator\Constraints as Assert,
    Doctrine\Common\Collections\ArrayCollection,
    Shopware\Components\Model\ModelEntity,
    Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_campaigns_maildata")
 */
class MailData extends ModelEntity
{
     /**
     * Primary Key - autoincrement value
     *
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $email
     * 
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;
   
    /**
     * @var integer $groupID
     *
     * @ORM\Column(name="groupID", type="integer", nullable=false)
     */
    private $groupID;

    /**
     * @var string $salutation
     *
     * @ORM\Column(name="salutation", type="string", nullable=true)
     */
    private $salutation;

    /**
     * @var string $title
     * 
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", nullable=true)
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", nullable=true)
     */
    private $lastname;

    /**
     * @var string $street
     *
     * @ORM\Column(name="street", type="string", nullable=true)
     */
    private $street;

    /**
     * @var string $zipcode
     *
     * @ORM\Column(name="zipcode", type="string", nullable=true)
     */
    private $zipcode;

    /**
     * @var string $city
     *
     * @ORM\Column(name="city", type="string", nullable=true)
     */
    private $city;

    /**
     * @var datetime $added
     *
     * @ORM\Column(name="added", type="datetime", nullable=true)
     */
    private $added;

    /**
     * @var datetime $double_optin_confirmed
     *
     * @ORM\Column(name="double_optin_confirmed", type="datetime", nullable=false)
     */
    private $double_optin_confirmed;

    /**
     * @var datetime $deleted
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

    /**
     * @param $email string
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
