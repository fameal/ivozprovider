<?php

namespace Ivoz\Api\JsonLd\Serializer\Normalizer;

use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\Api\ResourceClassResolverInterface;
use ApiPlatform\Core\Exception\InvalidArgumentException;
use ApiPlatform\Core\JsonLd\ContextBuilderInterface;
use ApiPlatform\Core\JsonLd\Serializer\JsonLdContextTrait;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Based on ApiPlatform\Core\JsonLd\Serializer\ItemNormalizer
 */
class EntityNormalizer implements NormalizerInterface
{
    use JsonLdContextTrait;

    const FORMAT = 'jsonld';

    /**
     * @var IriConverterInterface
     */
    protected $iriConverter;
    /**
     * @var ResourceClassResolverInterface
     */
    protected $resourceClassResolver;

    /**
     * @var ResourceMetadataFactoryInterface
     */
    private $resourceMetadataFactory;
    /**
     * @var ContextBuilderInterface
     */
    private $contextBuilder;

    public function __construct(
        ResourceMetadataFactoryInterface $resourceMetadataFactory,
        IriConverterInterface $iriConverter,
        ResourceClassResolverInterface $resourceClassResolver,
        ContextBuilderInterface $contextBuilder
    ) {
        $this->iriConverter = $iriConverter;
        $this->resourceClassResolver = $resourceClassResolver;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
        $this->contextBuilder = $contextBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return self::FORMAT === $format && ($data instanceof EntityInterface);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$object instanceof EntityInterface) {
            Throw new \Exception('Object must implement EntityInterface');
        }

        $this->iriConverter->getIriFromItem($object);
        return $this->normalizeDto($object->toDto(), $format, $context);
    }

    private function normalizeDto(DataTransferObjectInterface $dto, string $format, array $context, $isSubresource = false)
    {
        $resourceClass = substr(
            get_class($dto),
            0,
            strlen('Dto') * -1
        );
        $resourceMetadata = $this->resourceMetadataFactory->create($resourceClass);
        $data = $this->addJsonLdContext($this->contextBuilder, $resourceClass, $context);

        // Use resolved resource class instead of given resource class to support multiple inheritance child types
        $context['resource_class'] = $resourceClass;
        $context['iri'] = $this
            ->iriConverter
            ->getItemIriFromResourceClass(
                $resourceClass,
                ['id' => $dto->getId()]
            );

        $rawData = $dto->normalize($context['operation_type']);

        foreach ($rawData as $key => $value) {

            if ($value instanceof DataTransferObjectInterface) {
                if ($isSubresource) {
                    unset($rawData[$key]);
                    continue;
                }

                $embeddedContext = [
                    'item_operation_name' => 'get',
                    'operation_type' => 'item',
                    'request_uri' => $context['request_uri']
                ];

                try {
                    $rawData[$key] = $this->normalizeDto(
                        $value,
                        DataTransferObjectInterface::CONTEXT_COLLECTION,
                        $embeddedContext,
                        true
                    );

                } catch (\Exception $e) {
                    unset($rawData[$key]);
                }
            }
        }

        $data['@id'] = $context['iri'];
        $data['@type'] = $resourceMetadata->getIri() ?: $resourceMetadata->getShortName();

        return $data + $rawData;
    }
}