<?php

namespace Ivoz\Provider\Domain\Model\TargetPattern;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;

interface TargetPatternInterface extends LoggableEntityInterface
{
    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet();

    /**
     * @return TargetPatternDto
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
     * @return TargetPatternDto
     */
    public function toDto();

    /**
     * Set regExp
     *
     * @param string $regExp
     *
     * @return self
     */
    public function setRegExp($regExp);

    /**
     * Get regExp
     *
     * @return string
     */
    public function getRegExp();

    /**
     * Set brand
     *
     * @param \Ivoz\Provider\Domain\Model\Brand\BrandInterface $brand
     *
     * @return self
     */
    public function setBrand(\Ivoz\Provider\Domain\Model\Brand\BrandInterface $brand);

    /**
     * Get brand
     *
     * @return \Ivoz\Provider\Domain\Model\Brand\BrandInterface
     */
    public function getBrand();

    /**
     * Set name
     *
     * @param \Ivoz\Provider\Domain\Model\TargetPattern\Name $name
     *
     * @return self
     */
    public function setName(\Ivoz\Provider\Domain\Model\TargetPattern\Name $name);

    /**
     * Get name
     *
     * @return \Ivoz\Provider\Domain\Model\TargetPattern\Name
     */
    public function getName();

    /**
     * Set description
     *
     * @param \Ivoz\Provider\Domain\Model\TargetPattern\Description $description
     *
     * @return self
     */
    public function setDescription(\Ivoz\Provider\Domain\Model\TargetPattern\Description $description);

    /**
     * Get description
     *
     * @return \Ivoz\Provider\Domain\Model\TargetPattern\Description
     */
    public function getDescription();

}

