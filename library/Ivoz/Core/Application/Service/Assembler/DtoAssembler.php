<?php

namespace Ivoz\Core\Application\Service\Assembler;

use Ivoz\Core\Domain\Model\EntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DtoAssembler
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var array
     */
    protected $customAssemblers;

    public function __construct(
        ContainerInterface $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->customAssemblers = [];
    }

    public function toDTO(EntityInterface $targetEntity)
    {
        $assembler = $this->getAssembler($targetEntity);

        return $assembler
            ? $assembler->toDTO($targetEntity)
            : $targetEntity->toDTO();
    }

    private function getAssembler(EntityInterface $entity)
    {
        $assembler = null;
        $entityClass = get_class($entity);

        if (array_key_exists($entityClass, $this->customAssemblers)) {
            $assembler = $this->customAssemblers[$entityClass];
        } else {
            $assembler = $this->create($entity);
            $this->customAssemblers[$entityClass] = $assembler;
        }

        return $assembler;
    }

    /**
     * @param EntityInterface $targetEntity
     * @return null | DtoAssemblerInterface
     */
    private function create(EntityInterface $targetEntity)
    {
        $entityClass = get_class($targetEntity);
        $serviceClassName =
            str_replace(
                'Domain\\Model',
                'Application\\Service',
                $entityClass
            )
            . 'DtoAssembler';

        $serviceExists = $this->serviceContainer->has($serviceClassName);
        if (!$serviceExists) {
            return null;
        }

        return $this
            ->serviceContainer
            ->get($serviceClassName);
    }

}