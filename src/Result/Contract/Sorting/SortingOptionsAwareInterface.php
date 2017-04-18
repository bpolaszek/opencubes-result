<?php

namespace OpenCubes\Result\Contract\Sorting;

interface SortingOptionsAwareInterface
{
    /**
     * @return bool
     */
    public function isSortable(): bool;

    /**
     * @return SortingOptionInterface[]
     */
    public function getSortingOptions(): array;

    /**
     * @param string $key
     * @param string|null $direction (optionnal)
     * @return bool
     */
    public function canSortBy(string $key, string $direction = null): bool;

}