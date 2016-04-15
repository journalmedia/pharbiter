<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter;

class ClassLoader
{
    /** @var \Composer\Autoload\ClassLoader */
    private $adaptedClassLoader;

    public function __construct(\Composer\Autoload\ClassLoader $adaptedClassLoader)
    {
        $this->adaptedClassLoader = $adaptedClassLoader;
    }
}
