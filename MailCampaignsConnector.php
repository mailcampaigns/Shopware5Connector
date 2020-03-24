<?php

namespace MailCampaignsConnector;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;

class MailCampaignsConnector extends Plugin
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Front_StartDispatch' => 'onEnlightControllerFrontStartDispatch'
        ];
    }

    /**
     * @return string
     */
    public function onGetSubscriberApiController()
    {
        return $this->getPath() . '/Controllers/Api/Subscriber.php';
    }

    public function install(InstallContext $context)
    {


        $attributeService = $this->container->get('shopware_attribute.crud_service');

        $attributeService->update(
            's_order_details_attributes',
            'comment',
            'text', [
                'displayInBackend' => true,
                'label' => 'Article comment'
            ]
        );

    }

    /**
     * @return string
     */
    public function onGetQuoteApiController()
    {
        return $this->getPath() . '/Controllers/Api/Quote.php';
    }

    /**
     *
     */
    public function onEnlightControllerFrontStartDispatch()
    {
        $this->container->get('loader')->registerNamespace('Shopware\Components', $this->getPath() . '/Components/');
    }
}
