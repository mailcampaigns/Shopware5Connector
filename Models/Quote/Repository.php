<?php

namespace   MailCampaignsConnector\Models\Quote;

use Doctrine\DBAL\Connection;
use Shopware\Components\Model\ModelRepository;

/**
 * Repository for the quote model (Shopware\Models\Quote\Quote).
 * <br>
 * The quote model repository is responsible to load all quote data.
 */
class Repository extends ModelRepository
{
    /**
     * Loads all quotes. The $filter parameter can
     * be used to narrow the selection down to a category id.
     *
     * @param null $filter
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuotes($filter = null)
    {
        $builder = $this->getQuoteMainQuery($filter);

        return $builder->getQuery();
    }

    /**
     * @param null $filter
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuoteMainQuery($filter = null)
    {
        $builder = $this->createQueryBuilder('quote');
        return $builder;
    }
}