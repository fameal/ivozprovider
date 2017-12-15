<?php

namespace Ivoz\Provider\Domain\Model\EtagVersion;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\CollectionTransformerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class EtagVersionDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $etag;

    /**
     * @var \DateTime
     */
    private $lastChange;

    /**
     * @var integer
     */
    private $id;


    public function __constructor($id = null)
    {
        $this->setId($id);
    }

    /**
     * @return array
     */
    public function normalize(string $context)
    {
        return $this->toArray();
    }

    /**
     * @return void
     */
    public function denormalize(array $data, string $context)
    {
    }

    /**
     * @return array
     */
    public static function getPropertyMap()
    {
        return [
            'table',
            'etag',
            'lastChange',
            'id'
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'table' => $this->getTable(),
            'etag' => $this->getEtag(),
            'lastChange' => $this->getLastChange(),
            'id' => $this->getId()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function transformForeignKeys(ForeignKeyTransformerInterface $transformer)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function transformCollections(CollectionTransformerInterface $transformer)
    {

    }

    /**
     * @param string $table
     *
     * @return static
     */
    public function setTable($table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $etag
     *
     * @return static
     */
    public function setEtag($etag = null)
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * @param \DateTime $lastChange
     *
     * @return static
     */
    public function setLastChange($lastChange = null)
    {
        $this->lastChange = $lastChange;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastChange()
    {
        return $this->lastChange;
    }

    /**
     * @param integer $id
     *
     * @return static
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

