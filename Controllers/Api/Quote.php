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
     * Create new Quote
     *
     * POST /api/Quote
     */
    public function postAction()
    {
        $banner = $this->resource->create($this->Request()->getPost());

        $location = $this->apiBaseUrl . 'Quote/' . $banner->getId();

        $data = [
            'id' => $banner->getId(),
            'location' => $location,
        ];
        $this->View()->assign(['success' => true, 'data' => $data]);
        $this->Response()->setHeader('Location', $location);
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

    /**
     * Update One Quote
     *
     * PUT /api/Quote/{id}
     */
    public function putAction()
    {
        $bannerId = $this->Request()->getParam('id');
        $params = $this->Request()->getPost();

        /** @var \Shopware\Models\Quote\Quote $banner */
        $banner = $this->resource->update($bannerId, $params);

        $location = $this->apiBaseUrl . 'Quote/' . $bannerId;
        $data = [
            'id' => $banner->getId(),
            'location' => $location
        ];

        $this->View()->assign(['success' => true, 'data' => $data]);
    }

    /**
     * Delete One Quote
     *
     * DELETE /api/Quote/{id}
     */
    public function deleteAction()
    {
        $bannerId = $this->Request()->getParam('id');

        $this->resource->delete($bannerId);

        $this->View()->assign(['success' => true]);
    }
}
