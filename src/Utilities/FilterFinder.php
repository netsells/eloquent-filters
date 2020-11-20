<?php

namespace Netsells\EloquentFilters\Utilities;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Netsells\EloquentFilters\Attributes\FiltersModel;

final class FilterFinder
{
    private string $filterDirectory;
    private array $filters = [];
    private array $mappedFilters = [];

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

        $this->mapFilters();

        return $this->mappedFilters;
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

    private function mapFilters(): void
    {
        foreach ($this->filters as $filter) {
            $reflector = new ReflectionClass($filter);
            $attribute  = $reflector->getAttributes(FiltersModel::class)[0]->newInstance();

            if (!array_key_exists($attribute->model, $this->mappedFilters)) {
                $this->mappedFilters[$attribute->model] = [];
            }

            $this->mappedFilters[$attribute->model][$attribute->queryParameter] = $filter;
        }
    }
}
