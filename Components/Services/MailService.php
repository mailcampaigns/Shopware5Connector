<?php

namespace MailCampaignsConnector\Components\Services;


use MailCampaignsConnector\Models\MailAddresses\MailAddresses;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Mail\Repository;

class MailService
{

    /** Adds Existing Mail repository*/

    /** @var Repository $mailRepo */
    private $mailRepo;


    public function __construct(ModelManager $modelManager)
    {
        $this->mailRepo = $modelManager->getRepository(MailAddresses::class);
    }


    /** Adds optins to array of entity's
     * @return array
     */

    public function addOptinToList(array $data = [], int $optin = 2)
    {

        $list = [];
        if ($this->mailRepo !== null) {
            foreach ($data as $key => $value) {
                $single = $this->addOptinToSingle($value);
                if (($optin !== 0 && $single['optin'] === 1) || ($optin !== 1 && $single['optin'] === 0)) {
                    $list[] = $single;
                }
            }
        }

        return  $list;
    }

    /** Adds optin to single entity
     * @return array
     */

    public function addOptinToSingle(array $data = [])
    {
        $data['optin'] = 0;
        //$groupId = $data[$mailId]['groupID']; TODO Feature to seperate type of mail groups
        $mail = $data['email'];
        $userMail = $this->mailRepo->findOneBy(['email' => $mail]);
        if ($userMail !== null && !empty($userMail)) {
            $data['optin'] = 1;
        }

        return $data;
    }


    /** $optin = 1 // User is registered for mailcampaigns
        $optin = 0 // User is not registered for mailcampaigns
     */

    /** @return integer */

    public function getOptin()
    {
        if ($_GET['optin'] !== null) {
            $optin = (int) $_GET['optin'];
        } else {
            $optin = 2;
        }
        return $optin;
    }

}