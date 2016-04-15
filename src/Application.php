<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter;

use \Illuminate\Container\Container;

class Application
{
    /** @var Container */
    private $container;

    public function __construct()
    {
        $this->container = new Container;
    }

    public function make($className)
    {
        return $this->container[$className];
    }
}
