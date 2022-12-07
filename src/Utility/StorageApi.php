<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Utility;

use Exception;
use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Ifrost\ApiFoundation\ApiInterface;
use Ifrost\ApiFoundation\Exception\NotFoundException;
use Ifrost\ApiFoundation\Exception\NotUniqueException;
use Ifrost\EntityStorage\Exception\EntityAlreadyExists;
use Ifrost\EntityStorage\Exception\EntityNotExist;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;
use Ifrost\StorageApiBundle\Entity\EntityInterface;
use PlainDataTransformer\Transform;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;

class StorageApi implements ApiInterface
{
    private string $entityClassName;

    public function __construct(
        string $entityClassName,
        private EntityStorageInterface $storage,
        private ApiRequestInterface $apiRequest,
    ) {
        $this->setEntityClassName($entityClassName);
    }

    /**
     * @throws Exception
     */
    public function find(): JsonResponse
    {
        return new JsonResponse($this->storage->findAll()->getValues());
    }

    /**
     * @throws NotFoundException
     * @throws Exception
     */
    public function findOne(): JsonResponse
    {
        try {
            $uuid = Transform::toString($this->apiRequest->getAttribute('uuid', ''));

            return new JsonResponse($this->storage->find($uuid));
        } catch (EntityNotExist) {
            throw new NotFoundException(sprintf('Record "%s" not found', $this->entityClassName), 404);
        }
    }

    /**
     * @throws NotUniqueException
     * @throws Exception
     */
    public function create(): JsonResponse
    {
        $data = $this->apiRequest->getRequest($this->entityClassName::getFields());
        $data['uuid'] ??= (string) Uuid::uuid4();
        $entity = $this->entityClassName::createFromArray($data);

        try {
            $this->storage->create($entity);
        } catch (EntityAlreadyExists) {
            throw new NotUniqueException(sprintf('Unable to create "%s" due to not unique fields.', $this->entityClassName));
        }

        return new JsonResponse($entity);
    }

    /**
     * @throws NotFoundException
     * @throws Exception
     */
    public function update(): JsonResponse
    {
        try {
            $uuid = $this->apiRequest->getAttribute('uuid', '');
            $data = $this->apiRequest->getRequest($this->entityClassName::getFields());
            $data['uuid'] = $uuid;
            $entity = $this->entityClassName::createFromArray($data);
            $this->storage->update($entity);
        } catch (EntityNotExist) {
            throw new NotFoundException(sprintf('Record "%s" not found', $this->entityClassName), 404);
        }

        return new JsonResponse($entity);
    }


    /**
     * @throws NotFoundException
     * @throws Exception
     */
    public function modify(): JsonResponse
    {
        try {
            $uuid = Transform::toString($this->apiRequest->getAttribute('uuid', ''));
            $this->storage->modify($uuid, $this->apiRequest->getRequest($this->entityClassName::getFields(), false));

            return new JsonResponse($this->storage->find($uuid));
        } catch (EntityNotExist) {
            throw new NotFoundException(sprintf('Record "%s" not found', $this->entityClassName), 404);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(): JsonResponse
    {
        $uuid = Transform::toString($this->apiRequest->getAttribute('uuid', ''));
        $this->storage->delete($uuid);

        return new JsonResponse();
    }

    private function setEntityClassName(string $entityClassName): void
    {
        if (!in_array(EntityInterface::class, Transform::toArray(class_implements($entityClassName)))) {
            throw new \InvalidArgumentException(sprintf('Given argument entityClassName (%s) has to implement "%s" interface.', $entityClassName, EntityInterface::class));
        }

        $this->entityClassName = $entityClassName;
    }
}
