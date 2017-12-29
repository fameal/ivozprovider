<?php

namespace Ivoz\Kam\Domain\Model\PikeTrusted;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;

/**
 * PikeTrustedAbstract
 * @codeCoverageIgnore
 */
abstract class PikeTrustedAbstract
{
    /**
     * column: src_ip
     * @var string
     */
    protected $srcIp;

    /**
     * @var string
     */
    protected $proto;

    /**
     * column: from_pattern
     * @var string
     */
    protected $fromPattern;

    /**
     * column: ruri_pattern
     * @var string
     */
    protected $ruriPattern;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var integer
     */
    protected $priority = '0';


    use ChangelogTrait;

    /**
     * Constructor
     */
    protected function __construct($priority)
    {
        $this->setPriority($priority);
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @return PikeTrustedDto
     */
    public static function createDto()
    {
        return new PikeTrustedDto();
    }

    /**
     * Factory method
     * @param DataTransferObjectInterface $dto
     * @return self
     */
    public static function fromDto(DataTransferObjectInterface $dto)
    {
        /**
         * @var $dto PikeTrustedDto
         */
        Assertion::isInstanceOf($dto, PikeTrustedDto::class);

        $self = new static(
            $dto->getPriority());

        $self
            ->setSrcIp($dto->getSrcIp())
            ->setProto($dto->getProto())
            ->setFromPattern($dto->getFromPattern())
            ->setRuriPattern($dto->getRuriPattern())
            ->setTag($dto->getTag())
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
         * @var $dto PikeTrustedDto
         */
        Assertion::isInstanceOf($dto, PikeTrustedDto::class);

        $this
            ->setSrcIp($dto->getSrcIp())
            ->setProto($dto->getProto())
            ->setFromPattern($dto->getFromPattern())
            ->setRuriPattern($dto->getRuriPattern())
            ->setTag($dto->getTag())
            ->setPriority($dto->getPriority());



        $this->sanitizeValues();
        return $this;
    }

    /**
     * @return PikeTrustedDto
     */
    public function toDto()
    {
        return self::createDto()
            ->setSrcIp($this->getSrcIp())
            ->setProto($this->getProto())
            ->setFromPattern($this->getFromPattern())
            ->setRuriPattern($this->getRuriPattern())
            ->setTag($this->getTag())
            ->setPriority($this->getPriority());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'src_ip' => self::getSrcIp(),
            'proto' => self::getProto(),
            'from_pattern' => self::getFromPattern(),
            'ruri_pattern' => self::getRuriPattern(),
            'tag' => self::getTag(),
            'priority' => self::getPriority()
        ];
    }


    // @codeCoverageIgnoreStart

    /**
     * Set srcIp
     *
     * @param string $srcIp
     *
     * @return self
     */
    public function setSrcIp($srcIp = null)
    {
        if (!is_null($srcIp)) {
            Assertion::maxLength($srcIp, 50, 'srcIp value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->srcIp = $srcIp;

        return $this;
    }

    /**
     * Get srcIp
     *
     * @return string
     */
    public function getSrcIp()
    {
        return $this->srcIp;
    }

    /**
     * Set proto
     *
     * @param string $proto
     *
     * @return self
     */
    public function setProto($proto = null)
    {
        if (!is_null($proto)) {
            Assertion::maxLength($proto, 4, 'proto value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->proto = $proto;

        return $this;
    }

    /**
     * Get proto
     *
     * @return string
     */
    public function getProto()
    {
        return $this->proto;
    }

    /**
     * Set fromPattern
     *
     * @param string $fromPattern
     *
     * @return self
     */
    public function setFromPattern($fromPattern = null)
    {
        if (!is_null($fromPattern)) {
            Assertion::maxLength($fromPattern, 64, 'fromPattern value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->fromPattern = $fromPattern;

        return $this;
    }

    /**
     * Get fromPattern
     *
     * @return string
     */
    public function getFromPattern()
    {
        return $this->fromPattern;
    }

    /**
     * Set ruriPattern
     *
     * @param string $ruriPattern
     *
     * @return self
     */
    public function setRuriPattern($ruriPattern = null)
    {
        if (!is_null($ruriPattern)) {
            Assertion::maxLength($ruriPattern, 64, 'ruriPattern value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->ruriPattern = $ruriPattern;

        return $this;
    }

    /**
     * Get ruriPattern
     *
     * @return string
     */
    public function getRuriPattern()
    {
        return $this->ruriPattern;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return self
     */
    public function setTag($tag = null)
    {
        if (!is_null($tag)) {
            Assertion::maxLength($tag, 64, 'tag value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return self
     */
    public function setPriority($priority)
    {
        Assertion::notNull($priority, 'priority value "%s" is null, but non null value was expected.');
        Assertion::integerish($priority, 'priority value "%s" is not an integer or a number castable to integer.');

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



    // @codeCoverageIgnoreEnd
}

