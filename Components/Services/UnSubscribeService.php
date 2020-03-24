<?php

namespace MailCampaignsConnector\Components\Services;


use MailCampaignsConnector\Models\MailAddresses\MailAddresses;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Mail\Repository;

class UnSubscribeService
{


    /**  Get Mail Repository*/
    /** @var Repository $mailRepo */
    private $mailRepo;

    /**  Get ModelManager Repository*/
    /** @var ModelManager $modelManager */
    private $modelManager;


    public function __construct(ModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
        $this->mailRepo = $modelManager->getRepository(MailAddresses::class);
    }

    private function storeDeleted(Mail $mail)
    {
        //OPTIONAL store deleted mails in list for logging
    }


    /**
     * Unsubscribes user(s) by email and removes them from the database
     * @param string $mail
     * @return array
     */

    public function unSubscribe(string $mail)
    {
        $mailsToUnsubscribe = $this->mailRepo->findBy(['email' => $mail]);
        $result = ['success' => false, 'data' => []];
        if (empty($mailsToUnsubscribe)) {
            $result['data'] = ['errors' => 'No user subscribed with this email address'];
        } else {
            $total = 0;
            $removed = 0;
            $result['data']['mail'] = $mail;
            $result['success'] = true;
            foreach ($mailsToUnsubscribe as $mailToUnsubscribe) {
                /** @var Mail $mailToUnsubscribe */
                $total++;
                try {
                    $this->modelManager->remove($mailToUnsubscribe);
                    $this->modelManager->flush();
                    $removed++;
                } catch (\Exception $e) {
                    $result['success'] = false;
                    $result['data']['errors'][] = $e->getMessage();
                }
                $result['data']['total'] = $total;
                $result['data']['removed'] = $removed;
            }
        }
        return $result;
    }

}