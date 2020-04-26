<?php
declare(strict_types=1);

namespace NbpdSniff\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

final class DeclareStrictTypesSniff implements Sniff
{
    /**
     * Register the token sniff
     *
     * @return void
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }

    /**
     * Logic for sniff.
     *
     * @param PHP_CodeSniffer\Files\File $phpcsFile
     * @param mixed $stackPtr
     *
     * @return int|void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $hasStrictTypes = false;

        $tokens = $phpcsFile->getTokens();
        foreach ($tokens as $key => $token) {
            if ($token['type'] === 'T_DECLARE'
                && $tokens[($key + 2)]['content'] === 'strict_types'
                && $tokens[($key + 4)]['content'] === '1'
            ) {
                $hasStrictTypes = true;

                break;
            }
        }

        if ($hasStrictTypes === false) {
            $phpcsFile->addError(
                'File should be declare as strict_types=1.',
                $stackPtr,
                '',
                ''
            );
        }
    }
}
