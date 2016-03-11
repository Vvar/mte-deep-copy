<?php
namespace Mte\StorageDocument\Service;

use Mte\StorageDocument\Entity\File as EntityFile;
use Mte\StorageDocument\Repositories\File as RepositoriesFile;

/**
 * Class File
 * @package Mte\StorageDocument\Service
 */
class File extends AbstractService
{


    /**
     * @param EntityFile $entity
     * @return EntityFile
     * @throws \Exception
     * @throws \MteFile\Exception\ServiceException
     */
    public function saveFile(EntityFile $entity)
    {
        if ($entity->getTemporaryId()) {
            $fileInput = new \MteForm\InputFilter\FileInput();
            $fileInput->setValue(['id' => $entity->getTemporaryId()]);
            $fileInput->isValid();
            $fileData = $fileInput->getValue();
            /** @var $fileService \MteFile\Service\FileService */
            $fileService = $this->getServiceManager()->get('mteFileService');
            $fileOptions = $this->getServiceManager()->get('mteFileOptions');
            $protocol = $fileOptions->getDefaultProtocol();
            $entity->setStorageProtocol($protocol);
            $entity->setFileInfo($fileData);
            $entity->setHash($fileData['hash']);
            $uri = $protocol . '://' . $fileData['tmp_name'];
            $fileService->copy($uri, $entity->getUri());
        }
        return $entity;
    }

    /**
     * @param EntityFile $entity
     * @return EntityFile
     * @throws \Exception
     */
    public function save(EntityFile $entity)
    {
        $entity = $this->saveFile($entity);
        $entityManager = $this->getEntityManager();
        $entityManager->beginTransaction();
        try {
            $entityManager->persist($entity);
            $entityManager->flush($entity);
            $entityManager->commit();
        } catch (\Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
        return $entity;
    }

    /**
     * @param array|\Traversable $data
     * @return mixed
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }


    /**
     * todo удалять сам файл
     *
     * @param EntityFile $simpleDocument
     * @throws \Exception
     */
    public function remove(EntityFile $simpleDocument)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->beginTransaction();
        try {
            $entityManager->remove($simpleDocument);
            $entityManager->flush($simpleDocument);
            $entityManager->commit();
        } catch (\Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }

    /**
     * @param int $id
     * @return EntityFile
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @return RepositoriesFile
     */
    public function getRepository()
    {
        if (!$this->repository) {
            $this->repository = $this->getServiceManager()->get("storageDocumentRepositories_File");
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
