<?php

namespace OpenCubes\Result\Model\Facet;

use GuzzleHttp\Promise\PromiseInterface;
use OpenCubes\Result\Contract\Facet\FacetInterface;

trait FacetsAwareTrait
{
    /**
     * @var array
     */
    private $facets = [];

    /**
     * @inheritDoc
     */
    public function hasFacet(string $key): bool
    {
        /** @var FacetInterface[] $facets */
        $facets = iterable_to_array($this->getFacets());
        foreach ($facets AS $facet) {
            if ($key === $facet->getKey()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getFacet(string $key): ?FacetInterface
    {
        /** @var FacetInterface[] $facets */
        $facets = iterable_to_array($this->getFacets());
        foreach ($facets AS $facet) {
            if ($key === $facet->getKey()) {
                return $facet;
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getFacets(): iterable
    {
        if ($this->facets instanceof PromiseInterface) {
            $this->setFacets($this->facets->wait());
            return $this->getFacets();
        }
        foreach ($this->facets AS $key => &$facet) {
            if (!($facet instanceof PromiseInterface || $facet instanceof FacetInterface)) {
                throw new \InvalidArgumentException("A facet should be either a PromiseInterface or a FacetInterface");
            }
            if ($facet instanceof PromiseInterface) {
                $facet = $this->resolveFacetPromise($facet);
            }
            yield $key => $facet;
        }
    }

    /**
     * @param $facets
     * @return $this
     */
    public function setFacets($facets)
    {
        if (null === $facets) {
            $this->facets = [];
        }
        elseif ($facets instanceof PromiseInterface) {
            $this->facets = $facets;
        }
        else {
            if (!is_iterable($facets)) {
                throw new \InvalidArgumentException("Facets should be iterable");
            }
            $this->facets = $facets;
        }
        return $this;
    }

    /**
     * @param PromiseInterface $promise
     * @return FacetInterface
     */
    private function resolveFacetPromise(PromiseInterface $promise): FacetInterface
    {
        $facet = $promise->wait();
        if (!$facet instanceof FacetInterface) {
            throw new \RuntimeException("The resolved promise should return a FacetInterface object.");
        }
        return $facet;
    }

}