<?php

namespace   MailCampaignsConnector\Models\Subscriber;

use Doctrine\DBAL\Connection;
use Shopware\Components\Model\ModelRepository;

/**
 * Repository for the subscriber model (Shopware\Models\Subscriber\Subscriber).
 * <br>
 * The subscriber model repository is responsible to load all subscriber data.
 */
class Repository extends ModelRepository
{
    /**
     * Loads all subscribers. The $filter parameter can
     * be used to narrow the selection down to a category id.
     *
     * @param null $filter
     *
     * @return \Doctrine\ORM\Query
     */
    public function getSubscribers($filter = null)
    {
        $builder = $this->getSubscriberMainQuery($filter);

        return $builder->getQuery();
    }

    /**
     * @param null $filter
     *
     * @return \Doctrine\ORM\Query
     */
    public function getSubscriberMainQuery($filter = null)
    {
        $builder = $this->createQueryBuilder('subscriber');
        return $builder;
    }
}