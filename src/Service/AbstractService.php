<?php
namespace Mte\StorageDocument\Service;

use Doctrine\ORM\EntityRepository;
use MteBase\Service\AbstractService as MteAbstractService;

abstract class AbstractService extends MteAbstractService
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param mixed $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }
}
