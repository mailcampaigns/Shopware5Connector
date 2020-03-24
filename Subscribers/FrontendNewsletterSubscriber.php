<?php

namespace MailCampaignsConnector\Subscribers;


use Enlight\Event\SubscriberInterface;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Customer\Customer;

class FrontendNewsletterSubscriber  implements SubscriberInterface
{

    /** @return array  */

    public static function getSubscribedEvents()
    {
        return [

            //Hook to update changed timestamp on newsletter save
            'Shopware_Controllers_Frontend_Account::saveNewsletterAction::after' => 'updateChanged'

        ];
    }

    /** Construct Shopware Models and Modules*/

    /** @var ModelManager $modelManager */
    private $modelManager;

    /** @var \Shopware_Components_Modules $modulesManager */
    private $modulesManager;

    public function __construct(ModelManager $modelManager, \Shopware_Components_Modules $modulesManager)
    {
        $this->modelManager = $modelManager;
        $this->modulesManager = $modulesManager;
    }

    /**
     * update changed timestamp to current time.
     * @funtion updateChanged
     */

    public function updateChanged(\Enlight_Hook_HookArgs $args)
    {
        $admin = $this->modulesManager->Admin();
        if ($admin !== null) {
            $userData = $admin->sGetUserData();
            if ($userData !== null) {
                $userId = (int) $userData['additional']['user']['id'];
                /** @var \Shopware\Models\User\Repository $customerRepo */
                $customerRepo = $this->modelManager->getRepository(Customer::class);
                /** @var Customer $customer */
                $customer = $customerRepo->find($userId);
                if ($customer !== null) {
                    $customer->updateChangedTimestamp();

                    try {
                        $this->modelManager->persist($customer);
                        $this->modelManager->flush($customer);
                    } catch (Exception $e) {
                        // Potential error handler
                    }
                }
            }
        }
    }
}