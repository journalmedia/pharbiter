<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Providers;

use Illuminate\Support\ServiceProvider;
use JournalMedia\Pharbiter\Console\CheckCommand;
use JournalMedia\Pharbiter\Console\Kernel;
use Symfony\Component\Console\Application;

class ConsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(Kernel::class)
            ->needs(Application::class)
            ->give(function ($app) {
                $symfonyKernel = new \Symfony\Component\Console\Application;
                $symfonyKernel->setAutoExit(false);

                $symfonyKernel->add($app[CheckCommand::class]);

                return $symfonyKernel;
        });
    }
}
