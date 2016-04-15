<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter;

class Filesystem
{
    public function readBetween(string $path, int $startLine, int $endLine): string
    {
        return collect(explode("\n", file_get_contents($path)))
            ->filter(function ($content, $line) use ($startLine, $endLine) {
                return $line >= $startLine && $line <= $endLine;
            })
            ->implode("\n");
    }
}
