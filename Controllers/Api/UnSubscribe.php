<?php

use MailCampaignsConnector\Components\Services\UnSubscribeService;
use Shopware\Components\DependencyInjection\Container;

class Shopware_Controllers_Api_UnSubscribe extends Shopware_Controllers_Api_Rest
{
    /**
     * Call Unsubscribe action on chosen email
     * GET /api/UnSubscribe/{email}
     */

    public function getAction()
    {
        $mail = $this->Request()->getParam('id');
        /** @var Container $serviceContainer */
        $serviceContainer = $this->container->get('service_container');
        /** @var UnSubscribeService $unSubscribeService */
        $unSubscribeService = $serviceContainer->get('mail_campaigns_connector.un_subscribe_service');
        $view = $this->View();

        if ($view !== null) {
            if (isset($mail)) {
                $result = $unSubscribeService->unSubscribe($mail);
                $view->assign($result);
            } else {
                $view->assign(['success' => false, 'data' => ['errors' => 'Did not find mail parameter Try: shopname.com/UnSubscribe/johndoe@gmail.com']]);
            }
        }
    }
}
