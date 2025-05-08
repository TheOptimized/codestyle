<?php

declare(strict_types=1);

namespace TheOptimized\Codestyle\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class AutomaticCommentsFixer extends AbstractFixer
{
    public function getName(): string
    {
        return 'TheOptimized/automatic_comments';
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Removes the automatic "ClassName constructor." and "Class ClassName" comments.',
            [
                new CodeSample(
                    <<<'EOT'
                        <?php

                        namespace Project\TheNamespace;

                        /**
                         * Class TheClass
                         */
                        class TheClass
                        {
                            /**
                             * TheClass constructor.
                             */
                            public function __construct()
                            {

                            }
                        }
                        EOT
                ),
            ]
        );
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAnyTokenKindsFound([T_COMMENT, T_DOC_COMMENT]);
    }

    public function getPriority(): int
    {
        return 9000;
    }

    protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
    {
        /**
         * @var int   $index
         * @var Token $token
         */
        foreach ($tokens as $index => $token) {
            if (!$token->isComment()) {
                continue;
            }

            if (!$this->isPossibleComment($token)) {
                continue;
            }

            $content = $token->getContent();

            $content = preg_replace(
                '/\*\ (.*)\*.*constructor\./',
                '',
                $content
            );

            $content = preg_replace(
                '/\*\ Class\ (.*)/',
                '',
                $content
            );

            $content = preg_replace(
                '/\*\ Interface\ (.*)/',
                '',
                $content
            );

            $tokens[$index] = new Token([
                0 => $token->getId(),
                1 => $content,
            ]);
        }
    }

    private function isPossibleComment(Token $token): bool
    {
        return stripos($token->getContent(), 'constructor.') !== false ||
            stripos($token->getContent(), ' Interface ') !== false ||
            stripos($token->getContent(), ' Class ') !== false;
    }
}
