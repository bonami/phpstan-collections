<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

class LateStaticBindingStaticMethodReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    /** @var class-string */
    private string $class;

    /** @var array<string, int> */
    private array $methods;

    /**
     * @param class-string $class
     * @param array<string> $methods
     */
    private function __construct(string $class, array $methods)
    {
        $this->class = $class;
        $this->methods = array_flip($methods);
    }

    /**
     * @param class-string $class
     * @param array<string> $methods
     */
    public static function forMethods(string $class, array $methods): self
    {
        return new self($class, $methods);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return array_key_exists($methodReflection->getName(), $this->methods);
    }

    public function getTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope
    ): Type {
        $calledClassExpr = $methodCall->class;
        if ($calledClassExpr instanceof PropertyFetch) {
            $type = $scope->getType($calledClassExpr);
            if ($type->isClassString()->yes()) {
                return $type->getClassStringObjectType();
            }
        }

        assert($calledClassExpr instanceof Name);
        $calledClassExprString = $calledClassExpr->toString();
        $calledOnTopLevelParent = $calledClassExprString === $this->class
            || (in_array($calledClassExprString, ['self', 'static'], true)
                && $scope->getClassReflection() !== null
                && $scope->getClassReflection()->getName() === $this->class
            );

        if ($calledOnTopLevelParent) {
            return ParametersAcceptorSelector::selectFromArgs(
                $scope,
                $methodCall->getArgs(),
                $methodReflection->getVariants()
            )->getReturnType();
        }

        $calledInsideExtendedClass = $calledClassExprString === 'self';
        if ($calledInsideExtendedClass) {
            assert($scope->getClassReflection() !== null);
            return new ObjectType($scope->getClassReflection()->getName());
        }

        return new ObjectType($calledClassExprString);
    }
}
