<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FormatCode extends Command
{
    protected $signature = 'format {path?}';

    protected $description = 'Format code with Laravel Pint';

    public function handle(): int
    {
        $path = $this->argument('path') ?: '';
        $command = './vendor/bin/pint '.$path;

        $this->info('Formatowanie kodu...');
        $output = shell_exec($command);

        $this->line($output);
        $this->info('Formatowanie zakończone!');

        return Command::SUCCESS;
    }
}
