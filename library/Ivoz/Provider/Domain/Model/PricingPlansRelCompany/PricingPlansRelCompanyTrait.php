<?php

namespace Ivoz\Provider\Domain\Model\PricingPlansRelCompany;

use Ivoz\Core\Application\DataTransferObjectInterface;

/**
 * PricingPlansRelCompanyTrait
 * @codeCoverageIgnore
 */
trait PricingPlansRelCompanyTrait
{
    /**
     * @var integer
     */
    protected $id;


    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct(...func_get_args());

    }

    /**
     * @return PricingPlansRelCompanyDto
     */
    public static function createDto()
    {
        return new PricingPlansRelCompanyDto();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto PricingPlansRelCompanyDto
         */
        $self = parent::fromDto($dto);

        if ($dto->getId()) {
            $self->id = $dto->getId();
            $self->initChangelog();
        }

        return $self;
    }

    /**
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public function updateFromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto PricingPlansRelCompanyDto
         */
        parent::updateFromDto($dto);

        return $this;
    }

    /**
     * @return PricingPlansRelCompanyDto
     */
    public function toDto()
    {
        $dto = parent::toDto();
        return $dto
            ->setId($this->getId());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return parent::__toArray() + [
            'id' => self::getId()
        ];
    }


}

