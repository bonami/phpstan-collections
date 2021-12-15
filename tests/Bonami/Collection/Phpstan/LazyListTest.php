<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use ArrayIterator;
use Bonami\Collection\LazyList;
use PHPUnit\Framework\TestCase;

class LazyListTest extends TestCase
{
    public function testFillReturnType(): void
    {
        $genericList = LazyList::fill(new Foo());
        $this->requireLazyListOfFoo($genericList);
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fill(new Foo());
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testFromEmptyReturnType(): void
    {
        $genericList = LazyList::fromEmpty();
        $this->requireLazyListOfFoo($genericList);
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromEmpty();
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testFromArrayReturnType(): void
    {
        $genericList = LazyList::fromArray();
        $this->requireLazyListOfFoo($genericList);
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromArray([new Foo()]);
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testFromIterableReturnType(): void
    {
        $genericList = LazyList::fromIterable([new Foo()]);
        $this->requireLazyListOfFoo($genericList);
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()]);
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testOfReturnType(): void
    {
        $genericList = LazyList::of(new Foo());
        $this->requireLazyListOfFoo($genericList);
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::of(new Foo());
        $this->requireFooList($concreteList);
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testTakeReturnType(): void
    {
        $genericList = LazyList::fromIterable([new Foo()])->take(1);
        $this->requireLazyListOfFoo($genericList->take(1));
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()])->take(1);
        $this->requireFooList($concreteList->take(1));
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testFilterReturnType(): void
    {
        $tautology = static function () {
            return true;
        };
        $genericList = LazyList::fromIterable([new Foo()])->filter($tautology);
        $this->requireLazyListOfFoo($genericList->filter($tautology));
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()])->filter($tautology);
        $this->requireFooList($concreteList->filter($tautology));
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testDropWhileReturnType(): void
    {
        $tautology = static function () {
            return true;
        };
        $genericList = LazyList::fromIterable([new Foo()])->dropWhile($tautology);
        $this->requireLazyListOfFoo($genericList->dropWhile($tautology));
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()])->dropWhile($tautology);
        $this->requireFooList($concreteList->dropWhile($tautology));
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testDropReturnType(): void
    {
        $genericList = LazyList::fromIterable([new Foo()])->drop(0);
        $this->requireLazyListOfFoo($genericList->drop(0));
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()])->drop(0);
        $this->requireFooList($concreteList->drop(0));
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testConcatReturnType(): void
    {
        $genericList = LazyList::fromIterable([new Foo()])->concat([new Foo()]);
        $this->requireLazyListOfFoo($genericList->concat([new Foo()]));
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()])->concat([new Foo()]);
        $this->requireFooList($concreteList->concat([new Foo()]));
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testAddReturnType(): void
    {
        $genericList = LazyList::fromIterable([new Foo()])->add(new Foo());
        $this->requireLazyListOfFoo($genericList->add(new Foo()));
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()])->add(new Foo());
        $this->requireFooList($concreteList->add(new Foo()));
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    public function testInsertOnPositionReturnType(): void
    {
        $genericList = LazyList::fromIterable([new Foo()])->insertOnPosition(1, [new Foo()]);
        $this->requireLazyListOfFoo($genericList->insertOnPosition(1, [new Foo()]));
        self::assertInstanceOf(LazyList::class, $genericList);

        $concreteList = FooLazyList::fromIterable([new Foo()])->insertOnPosition(1, [new Foo()]);
        $this->requireFooList($concreteList->insertOnPosition(1, [new Foo()]));
        self::assertInstanceOf(FooLazyList::class, $concreteList);
    }

    /** @phpstan-param LazyList<Foo> $list */
    public function requireLazyListOfFoo(LazyList $list): void
    {
    }

    public function requireFooList(FooLazyList $list): void
    {
    }
}
