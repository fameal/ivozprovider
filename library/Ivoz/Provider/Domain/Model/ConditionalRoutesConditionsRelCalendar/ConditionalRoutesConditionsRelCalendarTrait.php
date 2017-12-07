<?php

namespace Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelCalendar;

use Ivoz\Core\Application\DataTransferObjectInterface;

/**
 * ConditionalRoutesConditionsRelCalendarTrait
 * @codeCoverageIgnore
 */
trait ConditionalRoutesConditionsRelCalendarTrait
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
     * @return ConditionalRoutesConditionsRelCalendarDto
     */
    public static function createDto()
    {
        return new ConditionalRoutesConditionsRelCalendarDto();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto ConditionalRoutesConditionsRelCalendarDto
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
         * @var $dto ConditionalRoutesConditionsRelCalendarDto
         */
        parent::updateFromDto($dto);

        return $this;
    }

    /**
     * @return ConditionalRoutesConditionsRelCalendarDto
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

