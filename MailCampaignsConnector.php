<?php

namespace MailCampaignsConnector;

use Shopware\Components\Plugin;

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
