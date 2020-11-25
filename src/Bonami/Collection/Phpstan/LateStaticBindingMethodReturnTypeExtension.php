<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

class LateStaticBindingMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    private $class;

    /** @var array<string, int> */
    private $methods;

    /**
     * @param string $class
     * @param array<string> $methods
     */
    private function __construct(string $class, array $methods)
    {
        $this->class = $class;
        $this->methods = array_flip($methods);
    }

    /**
     * @param string $class
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

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return array_key_exists($methodReflection->getName(), $this->methods);
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {

        $var = $methodCall->var;

        if ($var instanceof Variable && is_string($var->name)) {
            return $scope->getVariableType($var->name);
        }

        assert($var instanceof StaticCall && $var->class instanceof Name);

        $calledClass = $var->class->toString();

        $calledOnTopLevelParent = in_array($calledClass, ['self', $this->class]);

        $declaringClassReflection = $methodReflection->getDeclaringClass();
        return $calledOnTopLevelParent
            ? new GenericObjectType(
                $declaringClassReflection->getName(),
                $declaringClassReflection->typeMapToList($declaringClassReflection->getActiveTemplateTypeMap())
            )
            : new ObjectType($calledClass);
    }
}
