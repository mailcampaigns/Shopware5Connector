<?php

namespace Shopware\Components\Api\Resource;

use Shopware\Components\Api\Exception as ApiException;
use MailCampaignsConnector\Models\Quote\Quote as QuoteModel;

/**
 * Class Quote
 *
 * @package Shopware\Components\Api\Resource
 */
class Quote extends Resource
{
    /**
     * @return \MailCampaignsConnector\Models\Quote\Repository
     */
    public function getRepository()
    {
        return $this->getManager()->getRepository(QuoteModel::class);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $criteria
     * @param array $orderBy
     * @return array
     */
    public function getList($offset = 0, $limit = 25, array $criteria = [], array $orderBy = [])
    {
        //$builder = Shopware()->Models()->createQueryBuilder();
        //$builder->select(['quote'])->from(\MailCampaignsConnector\Models\Quote\Quote::class, 'quote');
		
		$builder = $this->getRepository()->createQueryBuilder('quote');
        
		$builder
			->addFilter($criteria)
            ->addOrderBy($orderBy)
            ->setFirstResult($offset)
            ->setMaxResults($limit);			
			
        $query = $builder->getQuery();
        $query->setHydrationMode($this->resultMode);
        $sql = $query->getSql();

        $paginator = $this->getManager()->createPaginator($query);

        //returns the total count of the query
        $totalResult = $paginator->count();

        //returns the Quote data
        $quotes = $paginator->getIterator()->getArrayCopy();
        $newquotes = array();
        $quotedates = array();
        $i=0;
        foreach($quotes as $quote)
        {
            $newquotes[$quote["sessionId"]]["customerId"] = $quote["customerId"];
            $newquotes[$quote["sessionId"]]["sessionId"] = $quote["sessionId"];
			 $newquotes[$quote["sessionId"]]["dateChanged"] = $quote["date"];
            
			/* Creation date */
			if ($newquotes[$quote["sessionId"]]["dateCreated"] == "")
				$newquotes[$quote["sessionId"]]["dateCreated"] = $quote["date"];
			
            if (strtotime($quote["date"]) < strtotime($newquotes[$quote["sessionId"]]["dateCreated"]))
            {
                $newquotes[$quote["sessionId"]]["dateCreated"] = $quote["date"];
            }
            /* Creation date */
            
            $quote["customerId"] = $quote["customerId"];
            $newquotes[$quote["sessionId"]]["details"][] = $quote;
        }
		
        return ['data' => $newquotes, 'total' => $totalResult]; // , 'sql' => $sql,
    }

    /**
     * Get One Quote Information
     *
     * @param $id
     * @return mixed
     * @throws ApiException\NotFoundException
     * @throws ApiException\ParameterMissingException
     */
    public function getOne($id)
    {
        $this->checkPrivilege('read');

        if (empty($id)) {
            throw new ApiException\ParameterMissingException();
        }

        $builder = $this->getRepository()
            ->createQueryBuilder('Quote')
            ->select('Quote')
            ->where('Quote.id = ?1')
            ->setParameter(1, $id);

        /** @var QuoteModel $quote */
        $quote = $builder->getQuery()->getOneOrNullResult($this->getResultMode());

        if (!$quote) {
            throw new ApiException\NotFoundException("Quote by id $id not found");
        }

        return $quote;
    }

    /**
     * @param $id
     * @param array $params
     * @return null|object
     * @throws ApiException\ValidationException
     * @throws ApiException\NotFoundException
     * @throws ApiException\ParameterMissingException
     */
    public function update($id, array $params)
    {
        $this->checkPrivilege('update');

        if (empty($id)) {
            throw new ApiException\ParameterMissingException();
        }

        /** @var $quote QuoteModel */
        $builder = $this->getRepository()
            ->createQueryBuilder('Quote')
            ->select('Quote')
            ->where('Quote.id = ?1')
            ->setParameter(1, $id);

        /** @var QuoteModel $quote */
        $quote = $builder->getQuery()->getOneOrNullResult(self::HYDRATE_OBJECT);

        if (!$quote) {
            throw new ApiException\NotFoundException("Quote by id $id not found");
        }

        $quote->fromArray($params);

        $violations = $this->getManager()->validate($quote);
        if ($violations->count() > 0) {
            throw new ApiException\ValidationException($violations);
        }

        $this->flush();

        return $quote;
    }
}
