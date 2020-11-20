<?php

namespace Netsells\EloquentFilters\Utilities;

use Symfony\Component\Finder\Finder;

final class FilterFinder
{
    private string $filterDirectory;
    private array $filters = [];

    public function __construct(string $directory = null)
    {
        $this->filterDirectory = $directory ?? base_path('app');
    }

    public function getFilterList(): array
    {
        $finder = new Finder();

        $files = $finder->in($this->filterDirectory)
            ->files()
            ->name('*.php')
            ->contains('/\#\[FiltersModel\(.*?\)\]/');

        foreach ($files as $file) {
            $this->addFilterClassFromPath($file);
        }

        return $this->filters;
    }

    private function addFilterClassFromPath(string $path): void
    {
        $fileSource = file_get_contents($path);

        preg_match('#^namespace\s+(.+?);$#sm', $fileSource, $matches);

        if (isset($matches[1])) {
            $namespace = $matches[1] . '\\';
            $class = $namespace . str_replace('.php', '', basename($path));
            array_push($this->filters, $class);
        }
    }
}
