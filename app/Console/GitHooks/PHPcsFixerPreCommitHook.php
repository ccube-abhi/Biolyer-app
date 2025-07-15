<?php

namespace App\Console\GitHooks;

use Igorsgm\GitHooks\Contracts\Hook;
use Symfony\Component\Process\Process;

class PHPcsFixerPreCommitHook implements Hook
{
    public function getName(): string
    {
        return 'php-cs-fixer-pre-commit';
    }

    public function handle(): void
    {
        // Run php-cs-fixer in fix mode
        $process = new Process(['./vendor/bin/php-cs-fixer', 'fix']);
        $process->run();

        if (! $process->isSuccessful()) {
            echo $process->getErrorOutput();
            exit(1);
        }

        // Re-stage all modified PHP files
        $gitAdd = new Process(['git', 'add', '-u']);
        $gitAdd->run();
    }
}
