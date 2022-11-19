<?php

namespace Ifrost\StorageApiBundle\Routing;

use Ifrost\StorageApiBundle\Attribute\StorageApi as StorageApiAttribute;
use Ifrost\StorageApiBundle\Utility\Action;
use Symfony\Component\Routing\Annotation\Route as RouteAttribute;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class AnnotatedRouteControllerLoader
{
    public function load(string $className): RouteCollection
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $className));
        }

        $class = new \ReflectionClass($className);

        if ($class->isAbstract()) {
            throw new \InvalidArgumentException(sprintf('Annotations from class "%s" cannot be read as it is abstract.', $class->getName()));
        }

        $collection = new RouteCollection();

        try {
            $attribute = $this->getAttribute($class);
        } catch (\Exception) {
            return $collection;
        }

        if ($attribute->getPath() === '') {
            return $collection;
        }

        $overwrittenActions = $this->getOverwrittenActions($class);
        $excludedActions = array_column($attribute->excludedActions(), 'value');

        foreach ($this->getActions() as $action) {
            if (
                in_array($action['name'], $overwrittenActions)
                || in_array($action['name'], $excludedActions)
            ) {
                continue;
            }

            $route = new Route(
                sprintf($action['route']['path'], $attribute->getPath()),
                [
                    '_controller' => sprintf('%s::%s', $class->getName(), $action['name']),
                ],
            );
            $route->setMethods($action['route']['methods']);
            $collection->add(sprintf('%s_%s', $attribute->getPath(), $action['route']['name']), $route);
        }

        return $collection;
    }

    /**
     * @throws \Exception
     */
    private function getAttribute(\ReflectionClass $class): StorageApiAttribute
    {
        $attributes = $class->getAttributes(StorageApiAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);
        $attributes[0] ?? throw new \Exception(sprintf('Controller "%s" has to declare "%s" attribute.', $class->getName(), StorageApiAttribute::class));

        return $attributes[0]->newInstance();
    }

    private function getOverwrittenActions(\ReflectionClass $class): array
    {
        return array_reduce(
            $class->getMethods(),
            function (array $carry, \ReflectionMethod $method) {
                if ($this->isOverwrittenAction($method)) {
                    $carry[] = $method->getName();
                }

                return $carry;
            },
            []
        );
    }

    private function isOverwrittenAction(\ReflectionMethod $method) {
        return $method->isPublic()
            && in_array($method->getName(), Action::values())
            && isset($method->getAttributes(RouteAttribute::class, \ReflectionAttribute::IS_INSTANCEOF)[0]);
    }

    /**
     * @return array<string, array>
     */
    private function getActions(): array
    {
        return [
            Action::FIND->value => [
                'name' => Action::FIND->value,
                'route' => [
                    'name' => 'find',
                    'path' => '/%s',
                    'methods' => [Request::METHOD_GET],
                ],
            ],
            Action::FIND_ONE->value => [
                'name' => Action::FIND_ONE->value,
                'route' => [
                    'name' => 'find_one',
                    'path' => '/%s/{uuid}',
                    'methods' => [Request::METHOD_GET],
                ],
            ],
            Action::CREATE->value => [
                'name' => Action::CREATE->value,
                'route' => [
                    'name' => 'create',
                    'path' => '/%s',
                    'methods' => [Request::METHOD_POST],
                ],
            ],
            Action::UPDATE->value => [
                'name' => Action::UPDATE->value,
                'route' => [
                    'name' => 'update',
                    'path' => '/%s/{uuid}',
                    'methods' => [Request::METHOD_PUT],
                ],
            ],
            Action::MODIFY->value => [
                'name' => Action::MODIFY->value,
                'route' => [
                    'name' => 'modify',
                    'path' => '/%s/{uuid}',
                    'methods' => [Request::METHOD_PATCH],
                ],
            ],
            Action::DELETE->value => [
                'name' => Action::DELETE->value,
                'route' => [
                    'name' => 'delete',
                    'path' => '/%s/{uuid}',
                    'methods' => [Request::METHOD_DELETE],
                ],
            ],
        ];
    }
}
