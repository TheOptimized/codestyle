<?php

declare(strict_types=1);

namespace TheOptimized\Codestyle;

final class PHP82 extends DefaultRules
{
    public static function getRules(): array
    {
        return array_merge(DefaultRules::getRules(), [
            '@PHP82Migration' => true,
        ]);
    }
}
