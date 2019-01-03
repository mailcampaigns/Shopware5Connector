<?php

namespace Shopware\Components\Api\Resource;

use Shopware\Components\Api\Exception as ApiException;
use MailCampaignsConnector\Models\Subscriber\Subscriber as SubscriberModel;

/**
 * Class Subscriber
 *
 * @package Shopware\Components\Api\Resource
 */
class Subscriber extends Resource
{
    /**
     * @return \MailCampaignsConnector\Models\Subscriber\Repository
     */
    public function getRepository()
    {
        return $this->getManager()->getRepository(SubscriberModel::class);
    }

    /**
     * Create new Subscriber
     *
     * @param array $params
     * @return SubscriberModel
     * @throws ApiException\ValidationException
     */
    public function create(array $params)
    {
        /** @var SubscriberModel $subscriber */
        $subscriber = new SubscriberModel();

        $subscriber->fromArray($params);

        $violations = $this->getManager()->validate($subscriber);

        /**
         * Handle Violation Errors
         */
        if ($violations->count() > 0) {
            throw new ApiException\ValidationException($violations);
        }

        $this->getManager()->persist($subscriber);
        $this->flush();

        return $subscriber;
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
        // $builder = Shopware()->Models()->createQueryBuilder();
        // $builder->select(['s.id, s.email, s'])
        //     ->from(\MailCampaignsConnector\Models\Subscriber\Subscriber::class, 's');
        // $results = $builder->getQuery()->getArrayResult();
        // $getDql = $builder->getDql();
        // $getSql = $builder->getQuery()->getSql();
        // return ['data' => $results, 'getDql' => $getDql, 'getSql' => $getSql];
        
        $builder = $this->getRepository()->createQueryBuilder('subscriber');
        $builder->addFilter($criteria)
            ->addOrderBy($orderBy)
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        $query = $builder->getQuery();
        $query->setHydrationMode($this->resultMode);

        $paginator = $this->getManager()->createPaginator($query);

        //returns the total count of the query
        $totalResult = $paginator->count();

        //returns the Subscriber data
        $subscriber = $paginator->getIterator()->getArrayCopy();
        // ookcool
        // $subscriber = $query->getSingleResult();
        // $subscriber = $query->getArrayResult();
        // $subscriber = $query->getScalarResult();
        // $subscriber = $query->getSingleScalarResult();
        
        $getDql = $builder->getDql();
        $getSql = $builder->getQuery()->getSql();
        
        return ['data' => $subscriber, 'total' => $totalResult];
    }

    /**
     * Delete Existing Subscriber
     *
     * @param $id
     * @return null|object
     * @throws ApiException\NotFoundException
     * @throws ApiException\ParameterMissingException
     */
    public function delete($id)
    {
        $this->checkPrivilege('delete');

        if (empty($id)) {
            throw new ApiException\ParameterMissingException();
        }

        $subscriber = $this->getRepository()->find($id);

        if (!$subscriber) {
            throw new ApiException\NotFoundException("Subscriber by id $id not found");
        }

        $this->getManager()->remove($subscriber);
        $this->flush();
    }

    /**
     * Get One Subscriber Information
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
            ->createQueryBuilder('Subscriber')
            ->select('Subscriber')
            ->where('Subscriber.id = ?1')
            ->setParameter(1, $id);

        /** @var SubscriberModel $subscriber */
        $subscriber = $builder->getQuery()->getOneOrNullResult($this->getResultMode());

        if (!$subscriber) {
            throw new ApiException\NotFoundException("Subscriber by id $id not found");
        }

        return $subscriber;
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

        /** @var $subscriber SubscriberModel */
        $builder = $this->getRepository()
            ->createQueryBuilder('Subscriber')
            ->select('Subscriber')
            ->where('Subscriber.id = ?1')
            ->setParameter(1, $id);

        /** @var SubscriberModel $subscriber */
        $subscriber = $builder->getQuery()->getOneOrNullResult(self::HYDRATE_OBJECT);

        if (!$subscriber) {
            throw new ApiException\NotFoundException("Subscriber by id $id not found");
        }

        $subscriber->fromArray($params);

        $violations = $this->getManager()->validate($subscriber);
        if ($violations->count() > 0) {
            throw new ApiException\ValidationException($violations);
        }

        $this->flush();

        return $subscriber;
    }
}
