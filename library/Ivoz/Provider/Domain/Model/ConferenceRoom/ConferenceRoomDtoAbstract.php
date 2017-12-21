<?php

namespace Ivoz\Provider\Domain\Model\ConferenceRoom;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\CollectionTransformerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class ConferenceRoomDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $pinProtected = 0;

    /**
     * @var string
     */
    private $pinCode;

    /**
     * @var integer
     */
    private $maxMembers = 0;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\Company\CompanyDto | null
     */
    private $company;


    public function __constructor($id = null)
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
            'name',
            'pinProtected',
            'pinCode',
            'maxMembers',
            'id',
            'company'
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'pinProtected' => $this->getPinProtected(),
            'pinCode' => $this->getPinCode(),
            'maxMembers' => $this->getMaxMembers(),
            'id' => $this->getId(),
            'company' => $this->getCompany()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function transformForeignKeys(ForeignKeyTransformerInterface $transformer)
    {
        $this->company = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\Company\\Company', $this->getCompanyId());
    }

    /**
     * {@inheritDoc}
     */
    public function transformCollections(CollectionTransformerInterface $transformer)
    {

    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param boolean $pinProtected
     *
     * @return static
     */
    public function setPinProtected($pinProtected = null)
    {
        $this->pinProtected = $pinProtected;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getPinProtected()
    {
        return $this->pinProtected;
    }

    /**
     * @param string $pinCode
     *
     * @return static
     */
    public function setPinCode($pinCode = null)
    {
        $this->pinCode = $pinCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPinCode()
    {
        return $this->pinCode;
    }

    /**
     * @param integer $maxMembers
     *
     * @return static
     */
    public function setMaxMembers($maxMembers = null)
    {
        $this->maxMembers = $maxMembers;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMaxMembers()
    {
        return $this->maxMembers;
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
     * @param \Ivoz\Provider\Domain\Model\Company\CompanyDto $company
     *
     * @return static
     */
    public function setCompany(\Ivoz\Provider\Domain\Model\Company\CompanyDto $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Company\CompanyDto
     */
    public function getCompany()
    {
        return $this->company;
    }

        /**
         * @param integer $id
         *
         * @return static
         */
        public function setCompanyId($id)
        {
            $value = $id
                ? new \Ivoz\Provider\Domain\Model\Company\CompanyDto($id)
                : null;

            return $this->setCompany($value);
        }

        /**
         * @return integer | null
         */
        public function getCompanyId()
        {
            if ($dto = $this->getCompany()) {
                return $dto->getId();
            }

            return null;
        }
}


