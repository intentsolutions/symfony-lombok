<?php

namespace IS\Bumbu\Compiler;

use IS\Bumbu\Attribute\Getter;
use IS\Bumbu\Attribute\Setter;
use IS\Bumbu\Compiler\Proxy\ProxyFactory;
use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CustomCompilerPass implements CompilerPassInterface
{
    const ATTRIBUTES = [
        Getter::class => AttributeStrategy\Getter::class,
        Setter::class => AttributeStrategy\Setter::class
    ];

    public function process(ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $id => $definition) {
            $class = $definition->getClass();

            if ($class && class_exists($class)) {
                $reflectionClass = new ReflectionClass($class);

                foreach ($reflectionClass->getProperties() as $property) {
                    foreach ($property->getAttributes() as $attribute) {

                        if (in_array($attribute->getName(), array_keys(self::ATTRIBUTES))) {

                            $proxyClass = (new ProxyFactory())->generateProxyClass(
                                $reflectionClass, self::ATTRIBUTES, $container);

                            $definition->setClass($proxyClass);
                        }
                    }
                }
            }
        }
    }
}