<?php

namespace Ivoz\Provider\Domain\Model\HuntGroupsRelUser;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;

/**
 * HuntGroupsRelUserAbstract
 * @codeCoverageIgnore
 */
abstract class HuntGroupsRelUserAbstract
{
    /**
     * @var integer
     */
    protected $timeoutTime;

    /**
     * @var integer
     */
    protected $priority;

    /**
     * @var \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupInterface
     */
    protected $huntGroup;

    /**
     * @var \Ivoz\Provider\Domain\Model\User\UserInterface
     */
    protected $user;


    use ChangelogTrait;

    /**
     * Constructor
     */
    protected function __construct()
    {

    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @return HuntGroupsRelUserDto
     */
    public static function createDto()
    {
        return new HuntGroupsRelUserDto();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto HuntGroupsRelUserDto
         */
        Assertion::isInstanceOf($dto, HuntGroupsRelUserDto::class);

        $self = new static();

        $self
            ->setTimeoutTime($dto->getTimeoutTime())
            ->setPriority($dto->getPriority())
            ->setHuntGroup($dto->getHuntGroup())
            ->setUser($dto->getUser())
        ;

        $self->sanitizeValues();
        $self->initChangelog();

        return $self;
    }

    /**
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public function updateFromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto HuntGroupsRelUserDto
         */
        Assertion::isInstanceOf($dto, HuntGroupsRelUserDto::class);

        $this
            ->setTimeoutTime($dto->getTimeoutTime())
            ->setPriority($dto->getPriority())
            ->setHuntGroup($dto->getHuntGroup())
            ->setUser($dto->getUser());



        $this->sanitizeValues();
        return $this;
    }

    /**
     * @return HuntGroupsRelUserDto
     */
    public function toDto()
    {
        return self::createDto()
            ->setTimeoutTime($this->getTimeoutTime())
            ->setPriority($this->getPriority())
            ->setHuntGroup($this->getHuntGroup() ? $this->getHuntGroup()->toDto() : null)
            ->setUser($this->getUser() ? $this->getUser()->toDto() : null);
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'timeoutTime' => self::getTimeoutTime(),
            'priority' => self::getPriority(),
            'huntGroupId' => self::getHuntGroup() ? self::getHuntGroup()->getId() : null,
            'userId' => self::getUser() ? self::getUser()->getId() : null
        ];
    }


    // @codeCoverageIgnoreStart

    /**
     * Set timeoutTime
     *
     * @param integer $timeoutTime
     *
     * @return self
     */
    public function setTimeoutTime($timeoutTime = null)
    {
        if (!is_null($timeoutTime)) {
            if (!is_null($timeoutTime)) {
                Assertion::integerish($timeoutTime, 'timeoutTime value "%s" is not an integer or a number castable to integer.');
            }
        }

        $this->timeoutTime = $timeoutTime;

        return $this;
    }

    /**
     * Get timeoutTime
     *
     * @return integer
     */
    public function getTimeoutTime()
    {
        return $this->timeoutTime;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return self
     */
    public function setPriority($priority = null)
    {
        if (!is_null($priority)) {
            if (!is_null($priority)) {
                Assertion::integerish($priority, 'priority value "%s" is not an integer or a number castable to integer.');
            }
        }

        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set huntGroup
     *
     * @param \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupInterface $huntGroup
     *
     * @return self
     */
    public function setHuntGroup(\Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupInterface $huntGroup = null)
    {
        $this->huntGroup = $huntGroup;

        return $this;
    }

    /**
     * Get huntGroup
     *
     * @return \Ivoz\Provider\Domain\Model\HuntGroup\HuntGroupInterface
     */
    public function getHuntGroup()
    {
        return $this->huntGroup;
    }

    /**
     * Set user
     *
     * @param \Ivoz\Provider\Domain\Model\User\UserInterface $user
     *
     * @return self
     */
    public function setUser(\Ivoz\Provider\Domain\Model\User\UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Ivoz\Provider\Domain\Model\User\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }



    // @codeCoverageIgnoreEnd
}

