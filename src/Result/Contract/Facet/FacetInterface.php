<?php

namespace OpenCubes\Result\Contract\Facet;

use OpenCubes\Common\Options\OptionsAwareInterface;

interface FacetInterface extends OptionsAwareInterface
{
    /**
     * Facet identifier.
     * @return string
     */
    public function getKey(): string;

    /**
     * Human readable name. Should fallback to getKey().
     * @return string
     */
    public function getName(): string;

    /**
     * Iterate over the facet values.
     * @return iterable
     */
    public function getValues(): iterable;

    /**
     * @param string $key
     * @return bool
     */
    public function hasValue(string $key): bool;

    /**
     * @param string $key
     * @return FacetValueInterface|null
     */
    public function getValue(string $key): ?FacetValueInterface;

    /**
     * Returns wether or not this facet is currently applied.
     * @return bool
     */
    public function isApplied(): bool;

    /**
     * Returns wether or not several values can be chosen for this facet.
     * @return bool
     */
    public function isMultiple(): bool;

    /**
     * getName() alias.
     * @return string
     */
    public function __toString(): string;
}