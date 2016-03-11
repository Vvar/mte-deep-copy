<?php
/**
 * @company MTE Telecom, Ltd.
 * @author Roman Malashin <malashinr@mte-telecom.ru>
 */
namespace Mte\StorageDocument\Service;

use Mte\StorageDocument\Entity\AbstractDocument;

/**
 * Interface DocumentInterface
 * @package Mte\StorageDocument\Service
 */
interface DocumentInterface
{
    /**
     * @param AbstractDocument $entity
     * @return mixed
     */
    public function save($entity);

    /**
     * @param array|\Traversable $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param AbstractDocument $document
     * @return mixed
     */
    public function remove($document);

    /**
     * @param int $id
     * @return mixed
     */
    public function get($id);
}
