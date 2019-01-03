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

        $result = $this->resource->getList($offset, $limit, $filter, $sort);
        $this->View()->assign(['success' => true, 'data' => $result]);
    }

    /**
     * Create new Subscriber
     *
     * POST /api/Subscriber
     */
    public function postAction()
    {
        $banner = $this->resource->create($this->Request()->getPost());

        $location = $this->apiBaseUrl . 'Subscriber/' . $banner->getId();

        $data = [
            'id' => $banner->getId(),
            'location' => $location,
        ];
        $this->View()->assign(['success' => true, 'data' => $data]);
        $this->Response()->setHeader('Location', $location);
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

    /**
     * Update One Subscriber
     *
     * PUT /api/Subscriber/{id}
     */
    public function putAction()
    {
        $bannerId = $this->Request()->getParam('id');
        $params = $this->Request()->getPost();

        /** @var \Shopware\Models\Subscriber\Subscriber $banner */
        $banner = $this->resource->update($bannerId, $params);

        $location = $this->apiBaseUrl . 'Subscriber/' . $bannerId;
        $data = [
            'id' => $banner->getId(),
            'location' => $location
        ];

        $this->View()->assign(['success' => true, 'data' => $data]);
    }

    /**
     * Delete One Subscriber
     *
     * DELETE /api/Subscriber/{id}
     */
    public function deleteAction()
    {
        $bannerId = $this->Request()->getParam('id');

        $this->resource->delete($bannerId);

        $this->View()->assign(['success' => true]);
    }
}
