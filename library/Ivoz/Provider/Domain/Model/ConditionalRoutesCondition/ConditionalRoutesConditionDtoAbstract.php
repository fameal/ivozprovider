<?php

namespace Ivoz\Provider\Domain\Model\ConditionalRoutesCondition;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\CollectionTransformerInterface;

/**
 * @codeCoverageIgnore
 */
abstract class ConditionalRoutesConditionDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var integer
     */
    private $priority = '1';

    /**
     * @var string
     */
    private $routeType;

    /**
     * @var string
     */
    private $numberValue;

    /**
     * @var string
     */
    private $friendValue;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto | null
     */
    private $conditionalRoute;

    /**
     * @var \Ivoz\Provider\Domain\Model\Ivr\IvrDto | null
     */
    private $ivr;

    /**
     * @var \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto | null
     */
    private $huntGroup;

    /**
     * @var \Ivoz\Provider\Domain\Model\User\UserDto | null
     */
    private $voicemailUser;

    /**
     * @var \Ivoz\Provider\Domain\Model\User\UserDto | null
     */
    private $user;

    /**
     * @var \Ivoz\Provider\Domain\Model\Queue\QueueDto | null
     */
    private $queue;

    /**
     * @var \Ivoz\Provider\Domain\Model\Locution\LocutionDto | null
     */
    private $locution;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto | null
     */
    private $conferenceRoom;

    /**
     * @var \Ivoz\Provider\Domain\Model\Extension\ExtensionDto | null
     */
    private $extension;

    /**
     * @var \Ivoz\Provider\Domain\Model\Country\CountryDto | null
     */
    private $numberCountry;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelMatchlist\ConditionalRoutesConditionsRelMatchlistDto[] | null
     */
    private $matchlists = null;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelSchedule\ConditionalRoutesConditionsRelScheduleDto[] | null
     */
    private $schedules = null;

    /**
     * @var \Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelCalendar\ConditionalRoutesConditionsRelCalendarDto[] | null
     */
    private $calendars = null;


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
            'priority',
            'routeType',
            'numberValue',
            'friendValue',
            'id',
            'conditionalRoute',
            'ivr',
            'huntGroup',
            'voicemailUser',
            'user',
            'queue',
            'locution',
            'conferenceRoom',
            'extension',
            'numberCountry',
            'matchlists',
            'schedules',
            'calendars'
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'priority' => $this->getPriority(),
            'routeType' => $this->getRouteType(),
            'numberValue' => $this->getNumberValue(),
            'friendValue' => $this->getFriendValue(),
            'id' => $this->getId(),
            'conditionalRoute' => $this->getConditionalRoute(),
            'ivr' => $this->getIvr(),
            'huntGroup' => $this->getHuntGroup(),
            'voicemailUser' => $this->getVoicemailUser(),
            'user' => $this->getUser(),
            'queue' => $this->getQueue(),
            'locution' => $this->getLocution(),
            'conferenceRoom' => $this->getConferenceRoom(),
            'extension' => $this->getExtension(),
            'numberCountry' => $this->getNumberCountry(),
            'matchlists' => $this->getMatchlists(),
            'schedules' => $this->getSchedules(),
            'calendars' => $this->getCalendars()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function transformForeignKeys(ForeignKeyTransformerInterface $transformer)
    {
        $this->conditionalRoute = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\ConditionalRoute\\ConditionalRoute', $this->getConditionalRouteId());
        $this->ivr = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\Ivr\\Ivr', $this->getIvrId());
        $this->huntGroup = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\HuntGroup\\HuntGroup', $this->getHuntGroupId());
        $this->voicemailUser = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\User\\User', $this->getVoicemailUserId());
        $this->user = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\User\\User', $this->getUserId());
        $this->queue = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\Queue\\Queue', $this->getQueueId());
        $this->locution = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\Locution\\Locution', $this->getLocutionId());
        $this->conferenceRoom = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\ConferenceRoom\\ConferenceRoom', $this->getConferenceRoomId());
        $this->extension = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\Extension\\Extension', $this->getExtensionId());
        $this->numberCountry = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\Country\\Country', $this->getNumberCountryId());
        if (!is_null($this->matchlists)) {
            $items = $this->getMatchlists();
            $this->matchlists = [];
            foreach ($items as $item) {
                $this->matchlists[] = $transformer->transform(
                    'Ivoz\\Provider\\Domain\\Model\\ConditionalRoutesConditionsRelMatchlist\\ConditionalRoutesConditionsRelMatchlist',
                    $item->getId() ?? $item
                );
            }
        }

        if (!is_null($this->schedules)) {
            $items = $this->getSchedules();
            $this->schedules = [];
            foreach ($items as $item) {
                $this->schedules[] = $transformer->transform(
                    'Ivoz\\Provider\\Domain\\Model\\ConditionalRoutesConditionsRelSchedule\\ConditionalRoutesConditionsRelSchedule',
                    $item->getId() ?? $item
                );
            }
        }

        if (!is_null($this->calendars)) {
            $items = $this->getCalendars();
            $this->calendars = [];
            foreach ($items as $item) {
                $this->calendars[] = $transformer->transform(
                    'Ivoz\\Provider\\Domain\\Model\\ConditionalRoutesConditionsRelCalendar\\ConditionalRoutesConditionsRelCalendar',
                    $item->getId() ?? $item
                );
            }
        }

    }

    /**
     * {@inheritDoc}
     */
    public function transformCollections(CollectionTransformerInterface $transformer)
    {
        $this->matchlists = $transformer->transform(
            'Ivoz\\Provider\\Domain\\Model\\ConditionalRoutesConditionsRelMatchlist\\ConditionalRoutesConditionsRelMatchlist',
            $this->matchlists
        );
        $this->schedules = $transformer->transform(
            'Ivoz\\Provider\\Domain\\Model\\ConditionalRoutesConditionsRelSchedule\\ConditionalRoutesConditionsRelSchedule',
            $this->schedules
        );
        $this->calendars = $transformer->transform(
            'Ivoz\\Provider\\Domain\\Model\\ConditionalRoutesConditionsRelCalendar\\ConditionalRoutesConditionsRelCalendar',
            $this->calendars
        );
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
     * @param string $routeType
     *
     * @return static
     */
    public function setRouteType($routeType = null)
    {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * @return string
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * @param string $numberValue
     *
     * @return static
     */
    public function setNumberValue($numberValue = null)
    {
        $this->numberValue = $numberValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumberValue()
    {
        return $this->numberValue;
    }

    /**
     * @param string $friendValue
     *
     * @return static
     */
    public function setFriendValue($friendValue = null)
    {
        $this->friendValue = $friendValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getFriendValue()
    {
        return $this->friendValue;
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
     * @param \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto $conditionalRoute
     *
     * @return static
     */
    public function setConditionalRoute(\Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto $conditionalRoute = null)
    {
        $this->conditionalRoute = $conditionalRoute;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto
     */
    public function getConditionalRoute()
    {
        return $this->conditionalRoute;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setConditionalRouteId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\ConditionalRoute\ConditionalRouteDto($id)
                : null;

            return $this->setConditionalRoute($value);
        }

        /**
         * @return integer | null
         */
        public function getConditionalRouteId()
        {
            if ($dto = $this->getConditionalRoute()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\Ivr\IvrDto $ivr
     *
     * @return static
     */
    public function setIvr(\Ivoz\Provider\Domain\Model\Ivr\IvrDto $ivr = null)
    {
        $this->ivr = $ivr;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Ivr\IvrDto
     */
    public function getIvr()
    {
        return $this->ivr;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setIvrId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\Ivr\IvrDto($id)
                : null;

            return $this->setIvr($value);
        }

        /**
         * @return integer | null
         */
        public function getIvrId()
        {
            if ($dto = $this->getIvr()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto $huntGroup
     *
     * @return static
     */
    public function setHuntGroup(\Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto $huntGroup = null)
    {
        $this->huntGroup = $huntGroup;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto
     */
    public function getHuntGroup()
    {
        return $this->huntGroup;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setHuntGroupId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupDto($id)
                : null;

            return $this->setHuntGroup($value);
        }

        /**
         * @return integer | null
         */
        public function getHuntGroupId()
        {
            if ($dto = $this->getHuntGroup()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\User\UserDto $voicemailUser
     *
     * @return static
     */
    public function setVoicemailUser(\Ivoz\Provider\Domain\Model\User\UserDto $voicemailUser = null)
    {
        $this->voicemailUser = $voicemailUser;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\User\UserDto
     */
    public function getVoicemailUser()
    {
        return $this->voicemailUser;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setVoicemailUserId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\User\UserDto($id)
                : null;

            return $this->setVoicemailUser($value);
        }

        /**
         * @return integer | null
         */
        public function getVoicemailUserId()
        {
            if ($dto = $this->getVoicemailUser()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\User\UserDto $user
     *
     * @return static
     */
    public function setUser(\Ivoz\Provider\Domain\Model\User\UserDto $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\User\UserDto
     */
    public function getUser()
    {
        return $this->user;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setUserId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\User\UserDto($id)
                : null;

            return $this->setUser($value);
        }

        /**
         * @return integer | null
         */
        public function getUserId()
        {
            if ($dto = $this->getUser()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\Queue\QueueDto $queue
     *
     * @return static
     */
    public function setQueue(\Ivoz\Provider\Domain\Model\Queue\QueueDto $queue = null)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Queue\QueueDto
     */
    public function getQueue()
    {
        return $this->queue;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setQueueId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\Queue\QueueDto($id)
                : null;

            return $this->setQueue($value);
        }

        /**
         * @return integer | null
         */
        public function getQueueId()
        {
            if ($dto = $this->getQueue()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\Locution\LocutionDto $locution
     *
     * @return static
     */
    public function setLocution(\Ivoz\Provider\Domain\Model\Locution\LocutionDto $locution = null)
    {
        $this->locution = $locution;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Locution\LocutionDto
     */
    public function getLocution()
    {
        return $this->locution;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setLocutionId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\Locution\LocutionDto($id)
                : null;

            return $this->setLocution($value);
        }

        /**
         * @return integer | null
         */
        public function getLocutionId()
        {
            if ($dto = $this->getLocution()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto $conferenceRoom
     *
     * @return static
     */
    public function setConferenceRoom(\Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto $conferenceRoom = null)
    {
        $this->conferenceRoom = $conferenceRoom;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto
     */
    public function getConferenceRoom()
    {
        return $this->conferenceRoom;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setConferenceRoomId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\ConferenceRoom\ConferenceRoomDto($id)
                : null;

            return $this->setConferenceRoom($value);
        }

        /**
         * @return integer | null
         */
        public function getConferenceRoomId()
        {
            if ($dto = $this->getConferenceRoom()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\Extension\ExtensionDto $extension
     *
     * @return static
     */
    public function setExtension(\Ivoz\Provider\Domain\Model\Extension\ExtensionDto $extension = null)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Extension\ExtensionDto
     */
    public function getExtension()
    {
        return $this->extension;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setExtensionId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\Extension\ExtensionDto($id)
                : null;

            return $this->setExtension($value);
        }

        /**
         * @return integer | null
         */
        public function getExtensionId()
        {
            if ($dto = $this->getExtension()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param \Ivoz\Provider\Domain\Model\Country\CountryDto $numberCountry
     *
     * @return static
     */
    public function setNumberCountry(\Ivoz\Provider\Domain\Model\Country\CountryDto $numberCountry = null)
    {
        $this->numberCountry = $numberCountry;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Country\CountryDto
     */
    public function getNumberCountry()
    {
        return $this->numberCountry;
    }

        /**
         * @param integer $id | null
         *
         * @return static
         */
        public function setNumberCountryId($id)
        {
            $value = !is_null($id)
                ? new \Ivoz\Provider\Domain\Model\Country\CountryDto($id)
                : null;

            return $this->setNumberCountry($value);
        }

        /**
         * @return integer | null
         */
        public function getNumberCountryId()
        {
            if ($dto = $this->getNumberCountry()) {
                return $dto->getId();
            }

            return null;
        }

    /**
     * @param array $matchlists
     *
     * @return static
     */
    public function setMatchlists($matchlists = null)
    {
        $this->matchlists = $matchlists;

        return $this;
    }

    /**
     * @return array
     */
    public function getMatchlists()
    {
        return $this->matchlists;
    }

    /**
     * @param array $schedules
     *
     * @return static
     */
    public function setSchedules($schedules = null)
    {
        $this->schedules = $schedules;

        return $this;
    }

    /**
     * @return array
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * @param array $calendars
     *
     * @return static
     */
    public function setCalendars($calendars = null)
    {
        $this->calendars = $calendars;

        return $this;
    }

    /**
     * @return array
     */
    public function getCalendars()
    {
        return $this->calendars;
    }
}


