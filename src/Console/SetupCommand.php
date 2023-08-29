<?php

declare(strict_types=1);

namespace StorePHP\Bundler\Console;

use Illuminate\Console\Command;
use StorePHP\Bundler\Setup;

final class SetupCommand extends Command
{
    protected $signature = 'sp:bundler:setup';

    protected $description = 'Bundles setup';

    public function handle(): void
    {
        $bundlesSetup = new Setup();
        $bundlesSetup->run();
        $this->info('Done');
    }
}
