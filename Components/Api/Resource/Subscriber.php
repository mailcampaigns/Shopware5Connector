<?php

namespace Shopware\Components\Api\Resource;

use Shopware\Components\Api\Exception as ApiException;
use MailCampaignsConnector\Models\MailAddresses\MailAddresses as MailAddressesModel;
use MailCampaignsConnector\Models\MailData\MailData as MailDataModel;

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
        return $this->getManager()->getRepository(MailAddressesModel::class);
    }

    /**
     * Create new Subscriber
     *
     * @param array $params
     * @return MailAddressesModel
     * @throws ApiException\ValidationException
     */
    public function create(array $params)
    {
        /** @var MailAddressesModel $subscriber */
        $subscriber = new MailAddressesModel();

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
        $builder = $this->getRepository()->createQueryBuilder('subscriber');
        $builder->select('subscriber.id','subscriber.customer','subscriber.groupID','subscriber.email','subscriber.lastmailing','subscriber.lastread','subscriber.added','subscriber.double_optin_confirmed','m.salutation','m.title','m.firstname','m.lastname','m.street','m.zipcode','m.city','m.deleted')
            ->leftJoin(\MailCampaignsConnector\Models\MailData\MailData::class, 'm', 'WITH', 'm.email = subscriber.email');
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

        $builder = $this->getRepository()->createQueryBuilder('subscriber');
        $builder->select('subscriber.id','subscriber.customer','subscriber.groupID','subscriber.email','subscriber.lastmailing','subscriber.lastread','subscriber.added','subscriber.double_optin_confirmed','m.salutation','m.title','m.firstname','m.lastname','m.street','m.zipcode','m.city','m.deleted')
            ->leftJoin(\MailCampaignsConnector\Models\MailData\MailData::class, 'm', 'WITH', 'm.email = subscriber.email');
            $builder->where('subscriber.id = ?1')
            ->setParameter(1, $id);
        $query = $builder->getQuery();
        $query->setHydrationMode($this->resultMode);

        /** @var MailAddressesModel $subscriber */
        $subscriber = $builder->getQuery()->getOneOrNullResult($this->getResultMode());

        if (!$subscriber) {
            throw new ApiException\NotFoundException("Subscriber by id $id not found");
        }

        return $subscriber;
    }
}
