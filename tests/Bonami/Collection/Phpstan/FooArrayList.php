<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\ArrayList;
use Bonami\Collection\Map;

/** @phpstan-extends ArrayList<Foo> */
class FooArrayList extends ArrayList
{

    /** @return Map<Foo, self> */
    public function groupByFoo(): Map
    {
        return $this->groupBy(static function (Foo $foo): Foo {
            return $foo;
        });
    }
}
