<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

class LateStaticReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    private $class;
    private $method;

    public function __construct(string $class, string $method)
    {
        $this->class = $class;
        $this->method = $method;
    }

    public static function forMethod(string $classWithMethod): self
    {
        [$class, $method] = explode('::', $classWithMethod);
        return new self($class, $method);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === $this->method;
    }

    public function getTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope
    ): Type {
        $declaringClassReflection = $methodReflection->getDeclaringClass();
        $calledClassExpr = $methodCall->class;
        assert($calledClassExpr instanceof Name);
        $calledOnTopLevelParent = in_array($calledClassExpr->toString(), ['self', $this->class]);

        return $calledOnTopLevelParent
            ? new GenericObjectType(
                $declaringClassReflection->getName(),
                $declaringClassReflection->typeMapToList($declaringClassReflection->getActiveTemplateTypeMap())
            )
            : new ObjectType($calledClassExpr->toString());
    }
}
