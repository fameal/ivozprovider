<?php

namespace Ivoz\Kam\Domain\Model\TrunksDomainAttr;

use Ivoz\Core\Application\DataTransferObjectInterface;

/**
 * TrunksDomainAttrTrait
 * @codeCoverageIgnore
 */
trait TrunksDomainAttrTrait
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
     * @return TrunksDomainAttrDto
     */
    public static function createDto()
    {
        return new TrunksDomainAttrDto();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto TrunksDomainAttrDto
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
         * @var $dto TrunksDomainAttrDto
         */
        parent::updateFromDto($dto);

        return $this;
    }

    /**
     * @return TrunksDomainAttrDto
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

