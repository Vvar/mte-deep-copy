<?php
/**
 * @company MTE Telecom, Ltd.
 * @author Roman Malashin <malashinr@mte-telecom.ru>
 */

namespace Mte\StorageDocument\Service;

use Mte\StorageDocument\Repositories\SimpleDocument as RepositoriesSimpleDocument;
use Mte\StorageDocument\Entity\SimpleDocument as EntitySimpleDocument;

class Document extends AbstractService implements DocumentInterface
{


    /**
     * @param EntitySimpleDocument $simpleDocument
     * @return EntitySimpleDocument
     * @throws \Exception
     */
    public function save($simpleDocument)
    {
        if (!$simpleDocument->getId()) {
            $simpleDocument->setCreatedDateTime(new \DateTime());
        }
        $simpleDocument->setUpdatedDatetime(new \DateTime());

        $entityManager = $this->getEntityManager();
        $entityManager->beginTransaction();
        try {
            $entityManager->persist($simpleDocument);
            $entityManager->flush($simpleDocument);
            $entityManager->commit();
        } catch (\Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
        return $simpleDocument;
    }

    /**
     * @param array|\Traversable $data
     * @return mixed
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function remove($document)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->beginTransaction();
        try {
            $entityManager->remove($document);
            $entityManager->flush($document);
            $entityManager->commit();
        } catch (\Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }

    /**
     * @param array $documents
     * @return bool
     * @throws \Exception
     */
    public function deleteDocuments(array $documents)
    {
        foreach ($documents as $document) {
            $this->remove($document);
        }
        return true;
    }

    /**
     * @param int $id
     * @return EntitySimpleDocument
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @return RepositoriesSimpleDocument
     */
    public function getRepository()
    {
        if (!$this->repository) {
            $this->repository = $this->getServiceManager()->get("storageDocumentRepositories_SimpleDocument");
        }
        return $this->repository;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getRepository()->getEntityManager();
    }
}
