<?php

namespace OpenCubes\Result\Contract\Facet;

interface FacetsAwareInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function hasFacet(string $key): bool;

    /**
     * @param string $key
     * @return null|FacetInterface
     */
    public function getFacet(string $key): ?FacetInterface;

    /**
     * @return iterable|FacetInterface[]
     */
    public function getFacets(): iterable;

}