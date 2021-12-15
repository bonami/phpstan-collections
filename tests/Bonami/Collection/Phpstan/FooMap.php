<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use Bonami\Collection\Map;

/** @phpstan-extends Map<int, Foo> */
class FooMap extends Map
{
    public function filterNothing(): self
    {
        return self::fromIterable($this->filter(static function (Foo $foo, int $i): bool {
            return true;
        }));
    }
}
