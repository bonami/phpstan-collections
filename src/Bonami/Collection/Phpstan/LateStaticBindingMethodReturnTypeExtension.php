<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
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
        return $scope->getType($methodCall->var);
    }
}
