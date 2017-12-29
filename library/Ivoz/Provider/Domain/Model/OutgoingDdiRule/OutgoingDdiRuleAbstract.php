<?php

namespace Ivoz\Provider\Domain\Model\OutgoingDdiRule;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;

/**
 * OutgoingDdiRuleAbstract
 * @codeCoverageIgnore
 */
abstract class OutgoingDdiRuleAbstract
{
    /**
     * @var string
     */
    protected $name;

    /**
     * comment: enum:keep|force
     * @var string
     */
    protected $defaultAction;

    /**
     * @var \Ivoz\Provider\Domain\Model\Company\CompanyInterface
     */
    protected $company;

    /**
     * @var \Ivoz\Provider\Domain\Model\Ddi\DdiInterface
     */
    protected $forcedDdi;


    use ChangelogTrait;

    /**
     * Constructor
     */
    protected function __construct($name, $defaultAction)
    {
        $this->setName($name);
        $this->setDefaultAction($defaultAction);
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @return OutgoingDdiRuleDto
     */
    public static function createDto()
    {
        return new OutgoingDdiRuleDto();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto OutgoingDdiRuleDto
         */
        Assertion::isInstanceOf($dto, OutgoingDdiRuleDto::class);

        $self = new static(
            $dto->getName(),
            $dto->getDefaultAction());

        $self
            ->setCompany($dto->getCompany())
            ->setForcedDdi($dto->getForcedDdi())
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
         * @var $dto OutgoingDdiRuleDto
         */
        Assertion::isInstanceOf($dto, OutgoingDdiRuleDto::class);

        $this
            ->setName($dto->getName())
            ->setDefaultAction($dto->getDefaultAction())
            ->setCompany($dto->getCompany())
            ->setForcedDdi($dto->getForcedDdi());



        $this->sanitizeValues();
        return $this;
    }

    /**
     * @return OutgoingDdiRuleDto
     */
    public function toDto()
    {
        return self::createDto()
            ->setName($this->getName())
            ->setDefaultAction($this->getDefaultAction())
            ->setCompany($this->getCompany() ? $this->getCompany()->toDto() : null)
            ->setForcedDdi($this->getForcedDdi() ? $this->getForcedDdi()->toDto() : null);
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'name' => self::getName(),
            'defaultAction' => self::getDefaultAction(),
            'companyId' => self::getCompany() ? self::getCompany()->getId() : null,
            'forcedDdiId' => self::getForcedDdi() ? self::getForcedDdi()->getId() : null
        ];
    }


    // @codeCoverageIgnoreStart

    /**
     * Set name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        Assertion::notNull($name, 'name value "%s" is null, but non null value was expected.');
        Assertion::maxLength($name, 50, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set defaultAction
     *
     * @param string $defaultAction
     *
     * @return self
     */
    public function setDefaultAction($defaultAction)
    {
        Assertion::notNull($defaultAction, 'defaultAction value "%s" is null, but non null value was expected.');
        Assertion::maxLength($defaultAction, 10, 'defaultAction value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        Assertion::choice($defaultAction, array (
          0 => 'keep',
          1 => 'force',
        ), 'defaultActionvalue "%s" is not an element of the valid values: %s');

        $this->defaultAction = $defaultAction;

        return $this;
    }

    /**
     * Get defaultAction
     *
     * @return string
     */
    public function getDefaultAction()
    {
        return $this->defaultAction;
    }

    /**
     * Set company
     *
     * @param \Ivoz\Provider\Domain\Model\Company\CompanyInterface $company
     *
     * @return self
     */
    public function setCompany(\Ivoz\Provider\Domain\Model\Company\CompanyInterface $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Ivoz\Provider\Domain\Model\Company\CompanyInterface
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set forcedDdi
     *
     * @param \Ivoz\Provider\Domain\Model\Ddi\DdiInterface $forcedDdi
     *
     * @return self
     */
    public function setForcedDdi(\Ivoz\Provider\Domain\Model\Ddi\DdiInterface $forcedDdi = null)
    {
        $this->forcedDdi = $forcedDdi;

        return $this;
    }

    /**
     * Get forcedDdi
     *
     * @return \Ivoz\Provider\Domain\Model\Ddi\DdiInterface
     */
    public function getForcedDdi()
    {
        return $this->forcedDdi;
    }



    // @codeCoverageIgnoreEnd
}

