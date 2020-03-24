<?php

/**
 * Class Shopware_Controllers_Api_Subscriber
 */
class Shopware_Controllers_Api_Subscriber extends Shopware_Controllers_Api_Rest
{
    /**
     * @var Shopware\Components\Api\Resource\Subscriber
     */
    protected $resource = null;

    public function init()
    {
        $this->resource = \Shopware\Components\Api\Manager::getResource('Subscriber');
    }

    /**
     * GET Request on /api/Subscriber
     */
    public function indexAction()
    {
        $limit = $this->Request()->getParam('limit', 1000);
        $offset = $this->Request()->getParam('start', 0);
        $sort = $this->Request()->getParam('sort', []);
        $filter = $this->Request()->getParam('filter', []);
        $optin = $this->Request()->getParam('optin', 2);
        $result = $this->resource->getList($offset, $limit, $filter, $sort, $optin);
        $this->View()->assign(['success' => true, 'data' => $result]);
    }


    /**
     * Get one Subscriber
     *
     * GET /api/Subscriber/{id}
     */
    public function getAction()
    {
        $id = $this->Request()->getParam('id');
        /** @var \Shopware\Models\Subscriber\Subscriber $banner */
        $banner = $this->resource->getOne($id);

        $this->View()->assign(['success' => true, 'data' => $banner]);
    }
}
