<?php

namespace Ivoz\Provider\Domain\Model\ExternalCallFilterRelCalendar;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;

interface ExternalCallFilterRelCalendarInterface extends LoggableEntityInterface
{
    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet();

    /**
     * @return ExternalCallFilterRelCalendarDto
     */
    public static function createDto();

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(\Ivoz\Core\Application\DataTransferObjectInterface $dto);

    /**
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public function updateFromDto(\Ivoz\Core\Application\DataTransferObjectInterface $dto);

    /**
     * @return ExternalCallFilterRelCalendarDto
     */
    public function toDto();

    /**
     * Set filter
     *
     * @param \Ivoz\Provider\Domain\Model\ExternalCallFilter\ExternalCallFilterInterface $filter
     *
     * @return self
     */
    public function setFilter(\Ivoz\Provider\Domain\Model\ExternalCallFilter\ExternalCallFilterInterface $filter = null);

    /**
     * Get filter
     *
     * @return \Ivoz\Provider\Domain\Model\ExternalCallFilter\ExternalCallFilterInterface
     */
    public function getFilter();

    /**
     * Set calendar
     *
     * @param \Ivoz\Provider\Domain\Model\Calendar\CalendarInterface $calendar
     *
     * @return self
     */
    public function setCalendar(\Ivoz\Provider\Domain\Model\Calendar\CalendarInterface $calendar);

    /**
     * Get calendar
     *
     * @return \Ivoz\Provider\Domain\Model\Calendar\CalendarInterface
     */
    public function getCalendar();

}

