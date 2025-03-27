<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\ArrayList;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Return_;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\CallableType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\VerbosityLevel;

class IterableFilterTypeNarrowingExtension implements DynamicMethodReturnTypeExtension, TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;

    /** @var class-string */
    private $class;

    /** @param class-string $class */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function setTypeSpecifier(TypeSpecifier $typeSpecifier): void
    {
        $this->typeSpecifier = $typeSpecifier;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'filter';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): ?Type {
        $type = $scope->getType($methodCall->var);

        if (!$type instanceof GenericObjectType) {
            return $type;
        }

        $args = $methodCall->getArgs();
        if (!array_key_exists(0, $args)) {
            return $type;
        }

        $arg = $methodCall->getArgs()[0]->value;
        if (!($arg instanceof Closure || $arg instanceof ArrowFunction)) {
            return $type;
        }

        $expr = Helpers::getSimpleClosureExpression($arg);
        if ($expr !== null) {
            $specifiedTypes = $this->typeSpecifier
                ->specifyTypesInCondition($scope, $expr, TypeSpecifierContext::createTruthy());

            if (count($specifiedTypes->getSureTypes()) !== 0) {
                return new GenericObjectType(
                    $methodReflection->getDeclaringClass()->getName(),
                    array_values(array_map(
                        static function (array $pair) use ($type) {
                            return TypeCombinator::intersect($type->getIterableValueType(), $pair[1]);
                        },
                        $specifiedTypes->getSureTypes(),
                    ))
                );
            }

            if (count($specifiedTypes->getSureNotTypes()) !== 0) {
                return new GenericObjectType(
                    $methodReflection->getDeclaringClass()->getName(),
                    array_values(array_map(
                        static function (array $pair) use ($type) {
                            return TypeCombinator::remove($type->getIterableValueType(), $pair[1]);
                        },
                        $specifiedTypes->getSureNotTypes(),
                    ))
                );
            }
            return $type;
        }

        return $type;
    }
}
