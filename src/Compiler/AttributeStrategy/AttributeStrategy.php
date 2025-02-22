<?php

namespace IS\Bumbu\Compiler\AttributeStrategy;

use ReflectionProperty;

interface AttributeStrategy
{
    public static function modifyClass(string $classCode, ReflectionProperty $property): string;
}