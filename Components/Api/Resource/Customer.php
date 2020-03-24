<?php

namespace MailCampaignsConnector\Components\Api\Resource;

use MailCampaignsConnector\Components\Services\MailService;

class Customer extends \Shopware\Components\Api\Resource\Customer
{



    /** @var MailService $mailService  */
    private $mailService;



    public function __construct()
    {
        $this->mailService = $this->getContainer()->get('mail_campaigns_connector.mail_service');
    }

    public function getContainer()
    {
        return parent::getContainer();
    }


    /**
     * Adds Optin to existing customer API single
     * @inheritdoc
     */
    public function getOne($id)
    {
        $result =  $this->mailService->addOptinToSingle((parent::getOne($id)));
        return $result;
    }

    /**
     * Adds Optin to existing customer API list
     * @inheritdoc
     */
    public function getList($offset = 0, $limit = 0, array $criteria = [], array $orderBy = [])
    {
        $optin = $this->mailService->getOptin();
        $result = parent::getList($offset, $limit, $criteria, $orderBy);
        $data = $result['data'];
        $result['data'] =  $this->mailService->addOptinToList($data, $optin);

        return $result;
    }
}
