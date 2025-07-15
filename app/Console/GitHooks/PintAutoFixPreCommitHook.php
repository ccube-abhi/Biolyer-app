<?php

namespace App\Console\GitHooks;

use Closure;
use Igorsgm\GitHooks\Contracts\PreCommitHook;
use Igorsgm\GitHooks\Git\ChangedFiles;
use Symfony\Component\Process\Process;

class PintAutoFixPreCommitHook implements PreCommitHook
{
    public function getName(): string
    {
        return 'pint-auto-fix-pre-commit-hook';
    }

    public function handle(ChangedFiles $files, Closure $next)
    {
        echo "🔧 Running Laravel Pint auto-fix...\n";

        // Run Pint
        $pint = new Process(['./vendor/bin/pint']);
        $pint->run();

        echo $pint->getOutput();

        // Re-add fixed files so they are included in the commit
        $add = new Process(['git', 'add', '.']);
        $add->run();

        return $next($files);
    }
}
