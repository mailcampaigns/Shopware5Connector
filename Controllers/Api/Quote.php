<?php

/**
 * Class Shopware_Controllers_Api_Quote
 */
class Shopware_Controllers_Api_Quote extends Shopware_Controllers_Api_Rest
{
    /**
     * @var Shopware\Components\Api\Resource\Quote
     */
    protected $resource = null;

    public function init()
    {
        $this->resource = \Shopware\Components\Api\Manager::getResource('Quote');
    }

    /**
     * GET Request on /api/Quote
     */
    public function indexAction()
    {
        $limit = $this->Request()->getParam('limit', 1000);
        $offset = $this->Request()->getParam('start', 0);
        $sort = $this->Request()->getParam('sort', []);
        $filter = $this->Request()->getParam('filter', []);

        $result = $this->resource->getList($offset, $limit, $filter, $sort);
        $this->View()->assign(['success' => true, 'data' => $result]);
    }

    /**
     * Get one Quote
     *
     * GET /api/Quote/{id}
     */
    public function getAction()
    {
        $id = $this->Request()->getParam('id');
        /** @var \Shopware\Models\Quote\Quote $banner */
        $banner = $this->resource->getOne($id);

        $this->View()->assign(['success' => true, 'data' => $banner]);
    }
}
