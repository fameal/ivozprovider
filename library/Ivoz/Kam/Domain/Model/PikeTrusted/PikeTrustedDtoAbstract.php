<?php

namespace Ivoz\Kam\Domain\Model\PikeTrusted;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\CollectionTransformerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class PikeTrustedDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var string
     */
    private $srcIp;

    /**
     * @var string
     */
    private $proto;

    /**
     * @var string
     */
    private $fromPattern;

    /**
     * @var string
     */
    private $ruriPattern;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var integer
     */
    private $priority = '0';

    /**
     * @var integer
     */
    private $id;


    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
     * @inheritdoc
     */
    public function normalize(string $context)
    {
        $response = $this->toArray();
        $contextProperties = $this->getPropertyMap($context);

        return array_filter(
            $response,
            function ($key) use ($contextProperties) {
                return in_array($key, $contextProperties);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * @inheritdoc
     */
    public function denormalize(array $data, string $context)
    {
    }

    /**
     * @inheritdoc
     */
    public static function getPropertyMap(string $context = '')
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id'];
        }

        return [
            'srcIp',
            'proto',
            'fromPattern',
            'ruriPattern',
            'tag',
            'priority',
            'id'
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'srcIp' => $this->getSrcIp(),
            'proto' => $this->getProto(),
            'fromPattern' => $this->getFromPattern(),
            'ruriPattern' => $this->getRuriPattern(),
            'tag' => $this->getTag(),
            'priority' => $this->getPriority(),
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
     * @param string $srcIp
     *
     * @return static
     */
    public function setSrcIp($srcIp = null)
    {
        $this->srcIp = $srcIp;

        return $this;
    }

    /**
     * @return string
     */
    public function getSrcIp()
    {
        return $this->srcIp;
    }

    /**
     * @param string $proto
     *
     * @return static
     */
    public function setProto($proto = null)
    {
        $this->proto = $proto;

        return $this;
    }

    /**
     * @return string
     */
    public function getProto()
    {
        return $this->proto;
    }

    /**
     * @param string $fromPattern
     *
     * @return static
     */
    public function setFromPattern($fromPattern = null)
    {
        $this->fromPattern = $fromPattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromPattern()
    {
        return $this->fromPattern;
    }

    /**
     * @param string $ruriPattern
     *
     * @return static
     */
    public function setRuriPattern($ruriPattern = null)
    {
        $this->ruriPattern = $ruriPattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getRuriPattern()
    {
        return $this->ruriPattern;
    }

    /**
     * @param string $tag
     *
     * @return static
     */
    public function setTag($tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param integer $priority
     *
     * @return static
     */
    public function setPriority($priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
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


