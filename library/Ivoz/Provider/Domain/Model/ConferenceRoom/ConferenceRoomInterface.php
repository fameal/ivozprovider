<?php

namespace Ivoz\Provider\Domain\Model\ConferenceRoom;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;

interface ConferenceRoomInterface extends LoggableEntityInterface
{
    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet();

    /**
     * @return ConferenceRoomDto
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
     * @return ConferenceRoomDto
     */
    public function toDto();

    /**
     * Set name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set pinProtected
     *
     * @param boolean $pinProtected
     *
     * @return self
     */
    public function setPinProtected($pinProtected);

    /**
     * Get pinProtected
     *
     * @return boolean
     */
    public function getPinProtected();

    /**
     * Set pinCode
     *
     * @param string $pinCode
     *
     * @return self
     */
    public function setPinCode($pinCode = null);

    /**
     * Get pinCode
     *
     * @return string
     */
    public function getPinCode();

    /**
     * Set maxMembers
     *
     * @param integer $maxMembers
     *
     * @return self
     */
    public function setMaxMembers($maxMembers);

    /**
     * Get maxMembers
     *
     * @return integer
     */
    public function getMaxMembers();

    /**
     * Set company
     *
     * @param \Ivoz\Provider\Domain\Model\Company\CompanyInterface $company
     *
     * @return self
     */
    public function setCompany(\Ivoz\Provider\Domain\Model\Company\CompanyInterface $company);

    /**
     * Get company
     *
     * @return \Ivoz\Provider\Domain\Model\Company\CompanyInterface
     */
    public function getCompany();

}

