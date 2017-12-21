<?php

namespace Ivoz\Kam\Domain\Model\Dispatcher;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\CollectionTransformerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class DispatcherDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var integer
     */
    private $setid = '0';

    /**
     * @var string
     */
    private $destination = '';

    /**
     * @var integer
     */
    private $flags = '0';

    /**
     * @var integer
     */
    private $priority = '0';

    /**
     * @var string
     */
    private $attrs = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\ApplicationServer\ApplicationServerDto | null
     */
    private $applicationServer;


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
            'setid',
            'destination',
            'flags',
            'priority',
            'attrs',
            'description',
            'id',
            'applicationServer'
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'setid' => $this->getSetid(),
            'destination' => $this->getDestination(),
            'flags' => $this->getFlags(),
            'priority' => $this->getPriority(),
            'attrs' => $this->getAttrs(),
            'description' => $this->getDescription(),
            'id' => $this->getId(),
            'applicationServer' => $this->getApplicationServer()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function transformForeignKeys(ForeignKeyTransformerInterface $transformer)
    {
        $this->applicationServer = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\ApplicationServer\\ApplicationServer', $this->getApplicationServerId());
    }

    /**
     * {@inheritDoc}
     */
    public function transformCollections(CollectionTransformerInterface $transformer)
    {

    }

    /**
     * @param integer $setid
     *
     * @return static
     */
    public function setSetid($setid = null)
    {
        $this->setid = $setid;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSetid()
    {
        return $this->setid;
    }

    /**
     * @param string $destination
     *
     * @return static
     */
    public function setDestination($destination = null)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param integer $flags
     *
     * @return static
     */
    public function setFlags($flags = null)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * @return integer
     */
    public function getFlags()
    {
        return $this->flags;
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
     * @param string $attrs
     *
     * @return static
     */
    public function setAttrs($attrs = null)
    {
        $this->attrs = $attrs;

        return $this;
    }

    /**
     * @return string
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * @param string $description
     *
     * @return static
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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

    /**
     * @param \Ivoz\Provider\Domain\Model\ApplicationServer\ApplicationServerDto $applicationServer
     *
     * @return static
     */
    public function setApplicationServer(\Ivoz\Provider\Domain\Model\ApplicationServer\ApplicationServerDto $applicationServer = null)
    {
        $this->applicationServer = $applicationServer;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\ApplicationServer\ApplicationServerDto
     */
    public function getApplicationServer()
    {
        return $this->applicationServer;
    }

        /**
         * @param integer $id
         *
         * @return static
         */
        public function setApplicationServerId($id)
        {
            $value = $id
                ? new \Ivoz\Provider\Domain\Model\ApplicationServer\ApplicationServerDto($id)
                : null;

            return $this->setApplicationServer($value);
        }

        /**
         * @return integer | null
         */
        public function getApplicationServerId()
        {
            if ($dto = $this->getApplicationServer()) {
                return $dto->getId();
            }

            return null;
        }
}


