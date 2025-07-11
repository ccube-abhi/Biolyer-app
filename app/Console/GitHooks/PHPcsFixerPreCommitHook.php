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
        $process = new Process(['./vendor/bin/php-cs-fixer', 'fix', '--dry-run', '--diff']);
        $process->run();

        if (!$process->isSuccessful()) {
            echo $process->getOutput();
            exit(1); // Cancel the commit
        }
    }
}
