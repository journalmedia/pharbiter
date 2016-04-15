<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter;

use \Illuminate\Container\Container;
use JournalMedia\Pharbiter\Providers\ConsoleServiceProvider;

class Application
{
    const SERVICE_PROVIDERS = [
        ConsoleServiceProvider::class
    ];

    /** @var Container */
    private $container;

    public function __construct()
    {
        $this->container = new Container;
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

    private function registerServiceProviders()
    {
        collect(self::SERVICE_PROVIDERS)
            ->each(function ($providerClassName) {
                (new $providerClassName($this->container))->register();
            });
    }
}
