<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\ArrayList;
use PHPUnit\Framework\TestCase;

class ArrayListTest extends TestCase
{

    public function testFromEmptyReturnType(): void
    {
        $genericList = ArrayList::fromEmpty();
        $this->requireArrayListOfFoo($genericList);
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromEmpty();
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testOfReturnType(): void
    {
        $genericList = ArrayList::of(new Foo());
        $this->requireArrayListOfFoo($genericList);
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::of(new Foo());
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testFillReturnType(): void
    {
        $genericList = ArrayList::fill(new Foo(), 1);
        $this->requireArrayListOfFoo($genericList);
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fill(new Foo(), 1);
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testFromIterableReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()]);
        $this->requireArrayListOfFoo($genericList);
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()]);
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    /** @phpstan-param ArrayList<Foo> $list */
    public function requireArrayListOfFoo(ArrayList $list): void
    {
    }

    public function requireFooList(FooArrayList $list): void
    {
    }
}
