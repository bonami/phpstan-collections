<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\ArrayList;
use Bonami\Collection\Map;
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

    public function testFilterReturnType(): void
    {
        $tautology = static function () {
            return true;
        };
        $genericList = ArrayList::fromIterable([new Foo()])->filter($tautology);
        $this->requireArrayListOfFoo($genericList->filter($tautology));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->filter($tautology);
        $this->requireFooList($concreteList->filter($tautology));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testUniqueByReturnType(): void
    {
        $tautology = static function () {
            return true;
        };
            $genericList = ArrayList::fromIterable([new Foo()])->uniqueBy($tautology);
            $this->requireArrayListOfFoo($genericList->uniqueBy($tautology));
            self::assertInstanceOf(ArrayList::class, $genericList);

            $concreteList = FooArrayList::fromIterable([new Foo()])->uniqueBy($tautology);
            $this->requireFooList($concreteList->uniqueBy($tautology));
            self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testUniqueReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->unique();
        $this->requireArrayListOfFoo($genericList->unique());
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->unique();
        $this->requireFooList($concreteList->unique());
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testUnionReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->union([new Foo()]);
        $this->requireArrayListOfFoo($genericList->union([new Foo()]));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->union([new Foo()]);
        $this->requireFooList($concreteList->union([new Foo()]));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testSortReturnType(): void
    {
        $cmp = static function ($a, $b) {
            return $a <=> $b;
        };
            $genericList = ArrayList::fromIterable([new Foo()])->sort($cmp);
            $this->requireArrayListOfFoo($genericList->sort($cmp));
            self::assertInstanceOf(ArrayList::class, $genericList);

            $concreteList = FooArrayList::fromIterable([new Foo()])->sort($cmp);
            $this->requireFooList($concreteList->sort($cmp));
            self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testTakeReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->take(1);
        $this->requireArrayListOfFoo($genericList->take(1));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->take(1);
        $this->requireFooList($concreteList->take(1));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testSliceReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->slice(0, 1);
        $this->requireArrayListOfFoo($genericList->slice(0, 1));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->slice(0, 1);
        $this->requireFooList($concreteList->slice(0, 1));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testMinusReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->minus([new Foo()]);
        $this->requireArrayListOfFoo($genericList->minus([new Foo()]));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->minus([new Foo()]);
        $this->requireFooList($concreteList->minus([new Foo()]));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testMinusOneReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->minusOne(new Foo());
        $this->requireArrayListOfFoo($genericList->minusOne(new Foo()));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->minusOne(new Foo());
        $this->requireFooList($concreteList->minusOne(new Foo()));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testConcatReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->concat([new Foo()]);
        $this->requireArrayListOfFoo($genericList->concat([new Foo()]));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->concat([new Foo()]);
        $this->requireFooList($concreteList->concat([new Foo()]));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testIntersectReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->intersect([new Foo()]);
        $this->requireArrayListOfFoo($genericList->intersect([new Foo()]));
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->intersect([new Foo()]);
        $this->requireFooList($concreteList->intersect([new Foo()]));
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testReverseReturnType(): void
    {
        $genericList = ArrayList::fromIterable([new Foo()])->reverse();
        $this->requireArrayListOfFoo($genericList->reverse());
        self::assertInstanceOf(ArrayList::class, $genericList);

        $concreteList = FooArrayList::fromIterable([new Foo()])->reverse();
        $this->requireFooList($concreteList->reverse());
        self::assertInstanceOf(FooArrayList::class, $concreteList);
    }

    public function testGroupByType(): void
    {
        $id = static function (Foo $i): Foo {
            return $i;
        };
        ArrayList::fromIterable([new Foo()])->groupBy($id);
        /** @var ArrayList<Foo> $genericList */
        $genericList = ArrayList::fromIterable([new Foo()]);
        $this->requireMapArrayListByFoo($genericList->groupBy($id));
        $this->requireMapArrayListByFoo($genericList->groupBy(static function (Foo $i): Foo {
            return $i;
        }));
        self::assertInstanceOf(Map::class, $genericList->groupBy($id));

        FooArrayList::fromIterable([new Foo()])->groupBy($id);
        $concreteList = FooArrayList::fromIterable([new Foo()]);
        $this->requireMapFooArrayListByFoo($concreteList->groupBy($id));
        self::assertInstanceOf(Map::class, $concreteList->groupBy($id));
    }

    /** @phpstan-param ArrayList<Foo> $list */
    public function requireArrayListOfFoo(ArrayList $list): void
    {
    }

    public function requireFooList(FooArrayList $list): void
    {
    }

    /** @phpstan-param Map<Foo, ArrayList<Foo>> $list */
    public function requireMapArrayListByFoo(Map $list): void
    {
    }

    /** @phpstan-param Map<Foo, FooArrayList> $list */
    public function requireMapFooArrayListByFoo(Map $list): void
    {
    }
}
