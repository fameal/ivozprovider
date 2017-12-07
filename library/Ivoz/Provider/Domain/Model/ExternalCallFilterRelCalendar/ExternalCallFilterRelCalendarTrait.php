<?php

namespace Ivoz\Provider\Domain\Model\ExternalCallFilterRelCalendar;

use Ivoz\Core\Application\DataTransferObjectInterface;

/**
 * ExternalCallFilterRelCalendarTrait
 * @codeCoverageIgnore
 */
trait ExternalCallFilterRelCalendarTrait
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
     * @return ExternalCallFilterRelCalendarDto
     */
    public static function createDto()
    {
        return new ExternalCallFilterRelCalendarDto();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto ExternalCallFilterRelCalendarDto
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
         * @var $dto ExternalCallFilterRelCalendarDto
         */
        parent::updateFromDto($dto);

        return $this;
    }

    /**
     * @return ExternalCallFilterRelCalendarDto
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

