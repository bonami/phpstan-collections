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

    public function testConcatReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]])->concat(new Map([[2, new Foo()]]));
        $this->requireMapOfFoo($genericList->concat(new Map([[2, new Foo()]])));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->concat(new Map([[2, new Foo()]]));
        $this->requireFooList($concreteList->concat(new Map([[2, new Foo()]])));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testMinusReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]])->minus(new Map([[2, new Foo()]]));
        $this->requireMapOfFoo($genericList->minus(new Map([[2, new Foo()]])));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->minus(new Map([[2, new Foo()]]));
        $this->requireFooList($concreteList->minus(new Map([[2, new Foo()]])));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testFilterReturnType(): void
    {
        $tautology = static function () {
            return true;
        };
        $genericList = Map::fromIterable([[1, new Foo()]])->filter($tautology);
        $this->requireMapOfFoo($genericList->filter($tautology));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->filter($tautology);
        $this->requireFooList($concreteList->filter($tautology));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testFilterKeysReturnType(): void
    {
        $tautology = static function () {
            return true;
        };
        $genericList = Map::fromIterable([[1, new Foo()]])->filterKeys($tautology);
        $this->requireMapOfFoo($genericList->filterKeys($tautology));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->filterKeys($tautology);
        $this->requireFooList($concreteList->filterKeys($tautology));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testTakeReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]])->take(1);
        $this->requireMapOfFoo($genericList->take(1));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->take(1);
        $this->requireFooList($concreteList->take(1));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testWithoutNullsReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]])->withoutNulls();
        $this->requireMapOfFoo($genericList->withoutNulls());
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->withoutNulls();
        $this->requireFooList($concreteList->withoutNulls());
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testWithoutKeysReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]])->withoutKeys([1]);
        $this->requireMapOfFoo($genericList->withoutKeys([1]));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->withoutKeys([1]);
        $this->requireFooList($concreteList->withoutKeys([1]));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testWithoutKeyReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]])->withoutKey(1);
        $this->requireMapOfFoo($genericList->withoutKey(1));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->withoutKey(1);
        $this->requireFooList($concreteList->withoutKey(1));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testSortKeysReturnType(): void
    {
        $cmp = static function ($a, $b) {
            return $a <=> $b;
        };
        $genericList = Map::fromIterable([[1, new Foo()]])->sortKeys($cmp);
        $this->requireMapOfFoo($genericList->sortKeys($cmp));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->sortKeys($cmp);
        $this->requireFooList($concreteList->sortKeys($cmp));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testGetByKeysReturnType(): void
    {
        $genericList = Map::fromIterable([[1, new Foo()]])->getByKeys([2]);
        $this->requireMapOfFoo($genericList->getByKeys([2]));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->getByKeys([2]);
        $this->requireFooList($concreteList->getByKeys([2]));
        self::assertInstanceOf(FooMap::class, $concreteList);
    }

    public function testSortValuesReturnType(): void
    {
        $cmp = static function ($a, $b) {
            return $a <=> $b;
        };
        $genericList = Map::fromIterable([[1, new Foo()]])->sortValues($cmp);
        $this->requireMapOfFoo($genericList->sortValues($cmp));
        self::assertInstanceOf(Map::class, $genericList);

        $concreteList = FooMap::fromIterable([[1, new Foo()]])->sortValues($cmp);
        $this->requireFooList($concreteList->sortValues($cmp));
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
