<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter;

use Composer\Autoload\ClassLoader as ComposerClassLoader;
use Illuminate\Container\Container;
use JournalMedia\Pharbiter\ClassLoader;
use JournalMedia\Pharbiter\Providers\ConsoleServiceProvider;

class Application
{
    const SERVICE_PROVIDERS = [
        ConsoleServiceProvider::class
    ];

    /** @var Container */
    private $container;

    public function __construct(ComposerClassLoader $composerClassLoader)
    {
        $this->container = new Container;
        $this->registerClassLoader($composerClassLoader);
        $this->registerServiceProviders();
    }

    public function make($className)
    {
        return $this->container[$className];
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    private function registerClassLoader(ComposerClassLoader $composerClassLoader)
    {
        $this->container[ClassLoader::class] = new ClassLoader($composerClassLoader);
    }

    private function registerServiceProviders()
    {
        collect(self::SERVICE_PROVIDERS)
            ->each(function ($providerClassName) {
                (new $providerClassName($this->container))->register();
            });
    }
}
