<?php

declare(strict_types=1);

namespace Bonami\Collection\Phpstan;

use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Return_;

class Helpers
{
    /** @param Expr\ArrowFunction|Expr\Closure $closure */
    public static function getSimpleClosureExpression($closure): ?Expr
    {
        if ($closure instanceof Expr\ArrowFunction) {
            return $closure->expr;
        }

        if (!($closure instanceof Expr\Closure)) {
            return null;
        }

        if (!isset($closure->stmts[0])) {
            return null;
        }

        if (!($closure->stmts[0] instanceof Return_)) {
            return null;
        }

        return $closure->stmts[0]->expr;
    }
}
