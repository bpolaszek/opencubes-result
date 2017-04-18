<?php

namespace OpenCubes\Result\Contract\Facet;

use OpenCubes\Common\Options\OptionsAwareInterface;

interface FacetValueInterface extends \Countable, OptionsAwareInterface
{
    /**
     * Facet value identifier.
     * @return string
     */
    public function getKey(): string;

    /**
     * Human readable name. Should fallback to getKey().
     * @return string
     */
    public function getName(): string;

    /**
     * Returns wether or not this value is currently applied.
     * @return bool
     */
    public function isApplied(): bool;

    /**
     * The number of items that match this value.
     * @return int
     */
    public function count(): int;

    /**
     * getName() alias.
     * @return string
     */
    public function __toString(): string;
}