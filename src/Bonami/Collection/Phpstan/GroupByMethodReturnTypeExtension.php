<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\Map;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\CallableType;
use PHPStan\Type\ClosureType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;

class GroupByMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    /** @var string */
    private $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'groupBy';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {
        $arg = $methodCall->args[0];
        assert($arg instanceof Arg);
        $closure = $scope->getType($arg->value);
        assert($closure instanceof ClosureType || $closure instanceof CallableType);

        $listType = $scope->getType($methodCall->var);

        return new GenericObjectType(
            Map::class,
            [
                $closure->getReturnType(),
                $listType instanceof ThisType ? $listType->getStaticObjectType() : $listType,
            ]
        );
    }
}
