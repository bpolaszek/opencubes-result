<?php

namespace OpenCubes\Result\Contract\Sorting;

use OpenCubes\Common\Options\OptionsAwareInterface;

interface SortingOptionInterface extends OptionsAwareInterface
{

    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    /**
     * The sorting identifier.
     * @return string
     */
    public function getKey(): string;

    /**
     * Human-readable sorting label.
     * Should fallback on key if null.
     * @return string
     */
    public function getName(): string;

    /**
     * Return an array of available directions (regardless of the currently applied direction): asc|desc
     * @return array
     */
    public function getAvailableDirections(): array;

    /**
     * @return bool
     */
    public function canSortAsc(): bool;

    /**
     * @return bool
     */
    public function canSortDesc(): bool;

    /**
     * Returns wether or not this sorting is applied.
     * @return bool
     */
    public function isApplied(): bool;

    /**
     * Returns the direction if this sorting is applied.
     * @return null|string
     */
    public function getAppliedDirection(): ?string;

    /**
     * getName() alias.
     * @return string
     */
    public function __toString(): string;

}