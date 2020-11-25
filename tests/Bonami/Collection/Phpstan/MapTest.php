<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\Map;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{

    public function testFromAssociativeArrayReturnType(): void
    {
        $genericList = Map::fromAssociativeArray([1 => new Foo()]);
        $this->requireMapOfFoo($genericList);
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromAssociativeArray([1 => new Foo()]);
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testFromOnlyReturnType(): void
    {
        $genericList = Map::fromOnly(1, new Foo());
        $this->requireMapOfFoo($genericList);
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromOnly(1, new Foo());
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testFromEmptyReturnType(): void
    {
        $genericList = Map::fromEmpty();
        $this->requireMapOfFoo($genericList);
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromEmpty();
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testFromIterableReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]]);
        $this->requireMapOfFoo($genericList);
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]]);
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    /** @phpstan-param Map<int, Foo> $list */
    public function requireMapOfFoo(Map $list): void
    {
    }

    public function requireFooList(FooMap $list): void
    {
    }
}
