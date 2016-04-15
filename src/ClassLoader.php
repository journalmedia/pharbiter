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

    public function getClassName(string $file): string
    {
        $filePath = sprintf("%s/%s", BASE_PATH, $file);

        $mapping = collect($this->adaptedClassLoader->getPrefixesPsr4())
            ->map(function ($paths) {
                return $paths[0];
            })
            ->filter(function ($basePath, $baseNamespace) use ($filePath) {
                return strpos($filePath, $basePath) === 0;
            });

        $basePath = $mapping->values()->pop();
        $baseNamespace = $mapping->keys()->pop();

        $remainingPath = str_replace($basePath, "", $filePath);

        $remainingNamespace = collect(explode("/", str_replace(".php", "", $remainingPath)))
            ->reject(function ($segment) {
                return $segment === "";
            })
            ->implode('\\');

        return $baseNamespace . $remainingNamespace;
    }
}
