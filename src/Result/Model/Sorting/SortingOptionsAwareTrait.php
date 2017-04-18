<?php

namespace OpenCubes\Result\Model\Sorting;

use OpenCubes\Result\Contract\Sorting\SortingOptionInterface;
use GuzzleHttp\Promise\PromiseInterface;

trait SortingOptionsAwareTrait
{
    /**
     * @var SortingOptionInterface[]
     */
    protected $sortingOptions = [];

    /**
     * @inheritDoc
     */
    public function isSortable(): bool
    {
        return !empty($this->sortingOptions);
    }

    /**
     * @return SortingOptionInterface[]
     */
    public function getSortingOptions(): array
    {
        return $this->sortingOptions instanceof PromiseInterface ? $this->setSortingOptions($this->sortingOptions->wait())->sortingOptions : $this->sortingOptions;
    }

    /**
     * @param SortingOptionInterface[] $sortingOptions
     * @return $this - Provides Fluent Interface
     */
    public function setSortingOptions($sortingOptions)
    {
        if ($sortingOptions instanceof PromiseInterface) {
            $this->sortingOptions = $sortingOptions;
        }
        else {
            $this->sortingOptions = (function (SortingOptionInterface ...$sortingOptions) {
                return $sortingOptions;
            })(...$sortingOptions);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function canSortBy(string $key, string $direction = null): bool
    {
        if (null !== $direction) {
            return $this->hasSortingOption($key) && in_array($direction, $this->getSortingOption($key)->getAvailableDirections());
        }
        else {
            return $this->hasSortingOption($key);
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasSortingOption(string $key): bool
    {
        foreach ($this->getSortingOptions() AS $sortingOption) {
            if ($key === $sortingOption->getKey()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $key
     * @return SortingOptionInterface|null
     */
    protected function getSortingOption(string $key): ?SortingOptionInterface
    {
        foreach ($this->getSortingOptions() AS $sortingOption) {
            if ($key === $sortingOption->getKey()) {
                return $sortingOption;
            }
        }
        return null;
    }
}