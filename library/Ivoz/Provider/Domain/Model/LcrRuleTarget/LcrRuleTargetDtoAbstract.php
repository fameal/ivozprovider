<?php

namespace Ivoz\Provider\Domain\Model\LcrRuleTarget;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\CollectionTransformerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class LcrRuleTargetDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var integer
     */
    private $lcrId = '1';

    /**
     * @var integer
     */
    private $priority;

    /**
     * @var integer
     */
    private $weight = '1';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\LcrRule\LcrRuleDto | null
     */
    private $rule;

    /**
     * @var \Ivoz\Provider\Domain\Model\LcrGateway\LcrGatewayDto | null
     */
    private $gw;

    /**
     * @var \Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRoutingDto | null
     */
    private $outgoingRouting;


    public function __constructor($id = null)
    {
        $this->setId($id);
    }

    /**
     * @inheritdoc
     */
    public function normalize(string $context)
    {
        return $this->toArray();
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
        if ($context === self::CONTEXT_SIMPLE) {
            return ['id'];
        }

        return [
            'lcrId',
            'priority',
            'weight',
            'id',
            'rule',
            'gw',
            'outgoingRouting'
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'lcrId' => $this->getLcrId(),
            'priority' => $this->getPriority(),
            'weight' => $this->getWeight(),
            'id' => $this->getId(),
            'rule' => $this->getRule(),
            'gw' => $this->getGw(),
            'outgoingRouting' => $this->getOutgoingRouting()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function transformForeignKeys(ForeignKeyTransformerInterface $transformer)
    {
        $this->rule = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\LcrRule\\LcrRule', $this->getRuleId());
        $this->gw = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\LcrGateway\\LcrGateway', $this->getGwId());
        $this->outgoingRouting = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\OutgoingRouting\\OutgoingRouting', $this->getOutgoingRoutingId());
    }

    /**
     * {@inheritDoc}
     */
    public function transformCollections(CollectionTransformerInterface $transformer)
    {

    }

    /**
     * @param integer $lcrId
     *
     * @return static
     */
    public function setLcrId($lcrId = null)
    {
        $this->lcrId = $lcrId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLcrId()
    {
        return $this->lcrId;
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
     * @param integer $weight
     *
     * @return static
     */
    public function setWeight($weight = null)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
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
     * @param \Ivoz\Provider\Domain\Model\LcrRule\LcrRuleDto $rule
     *
     * @return static
     */
    public function setRule(\Ivoz\Provider\Domain\Model\LcrRule\LcrRuleDto $rule = null)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\LcrRule\LcrRuleDto
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\LcrGateway\LcrGatewayDto $gw
     *
     * @return static
     */
    public function setGw(\Ivoz\Provider\Domain\Model\LcrGateway\LcrGatewayDto $gw = null)
    {
        $this->gw = $gw;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\LcrGateway\LcrGatewayDto
     */
    public function getGw()
    {
        return $this->gw;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRoutingDto $outgoingRouting
     *
     * @return static
     */
    public function setOutgoingRouting(\Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRoutingDto $outgoingRouting = null)
    {
        $this->outgoingRouting = $outgoingRouting;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\OutgoingRouting\OutgoingRoutingDto
     */
    public function getOutgoingRouting()
    {
        return $this->outgoingRouting;
    }
}


