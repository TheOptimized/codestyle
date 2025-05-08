<?php

declare(strict_types=1);

namespace TheOptimized\Codestyle;

use TheOptimized\Codestyle\Fixer\AutomaticCommentsFixer;
use TheOptimized\Codestyle\Fixer\MultiToSingleLineAnnotationFixer;

final class CustomFixer
{
    public static function getCustomFixer(): array
    {
        return [
            new AutomaticCommentsFixer(),
            new MultiToSingleLineAnnotationFixer(),
        ];
    }
}
