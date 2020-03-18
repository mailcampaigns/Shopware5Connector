<?php

namespace   MailCampaignsConnector\Models\MailAddresses;

use Symfony\Component\Validator\Constraints as Assert,
    Doctrine\Common\Collections\ArrayCollection,
    Shopware\Components\Model\ModelEntity,
    Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_campaigns_mailaddresses")
 */
class MailAddresses extends ModelEntity
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
     * @var integer $customer
     *
     * @ORM\Column(name="customer", type="integer", nullable=false)
     */
    private $customer;

    /**
     * @var integer $groupID
     *
     * @ORM\Column(name="groupID", type="integer", nullable=false)
     */
    private $groupID;

    /**
     * @var string $email
     * 
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @var integer $lastmailing
     *
     * @ORM\Column(name="lastmailing", type="integer", nullable=false)
     */
    private $lastmailing;

    /**
     * @var integer $lastread
     *
     * @ORM\Column(name="lastread", type="integer", nullable=false)
     */
    private $lastread;
   
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
