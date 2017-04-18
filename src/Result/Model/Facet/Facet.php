<?php

namespace OpenCubes\Result\Model\Facet;

use GuzzleHttp\Promise\PromiseInterface;
use OpenCubes\Common\Options\OptionsAwareTrait;
use OpenCubes\Result\Contract\Facet\FacetInterface;
use OpenCubes\Result\Contract\Facet\FacetValueInterface;

class Facet implements FacetInterface
{
    use OptionsAwareTrait;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array|FacetValueInterface[]
     */
    private $values = [];

    /**
     * @var bool
     */
    private $applied = false;

    /**
     * @var bool
     */
    private $multiple = false;

    /**
     * Facet constructor.
     * @param string $key
     * @param string $name
     * @param array|FacetValueInterface[] $values
     * @param bool $applied
     * @param bool $multiple
     */
    public function __construct(string $key, string $name = null, $values = null, bool $applied = false, bool $multiple = false)
    {
        $this->key      = $key;
        $this->name     = $name;
        $this->setValues($values);
        $this->applied  = $applied;
        $this->multiple = $multiple;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $name
     * @return $this - Provides Fluent Interface
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name ?? $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getValues(): iterable
    {
        if ($this->values instanceof PromiseInterface) {
            $this->setValues($this->values->wait());
            return $this->getValues();
        }
        foreach ($this->values AS $key => &$value) {
            if (!($value instanceof PromiseInterface || $value instanceof FacetValueInterface)) {
                throw new \InvalidArgumentException("A facet value should be either a PromiseInterface or a FacetValueInterface");
            }
            if ($value instanceof PromiseInterface) {
                $value = $this->resolveFacetValuePromise($value);
            }
            yield $key => $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function hasValue(string $key): bool
    {
        /** @var FacetValueInterface[] $values */
        $values = iterable_to_array($this->getValues());
        foreach ($values as $value) {
            if ($key === $value->getKey()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getValue(string $key): ?FacetValueInterface
    {
        /** @var FacetValueInterface[] $values */
        $values = iterable_to_array($this->getValues());
        foreach ($values as $value) {
            if ($key === $value->getKey()) {
                return $value;
            }
        }
        return null;
    }

    /**
     * @param $values
     * @return $this
     */
    public function setValues($values)
    {
        if (null === $values) {
            $this->values = [];
        }
        elseif ($values instanceof PromiseInterface) {
            $this->values = $values;
        }
        else {
            if (!is_iterable($values)) {
                throw new \InvalidArgumentException("Facets values should be iterable");
            }
            $this->values = $values;
        }
        return $this;
    }

    /**
     * @param bool $applied
     * @return $this - Provides Fluent Interface
     */
    public function setApplied(bool $applied)
    {
        $this->applied = $applied;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isApplied(): bool
    {
        return $this->applied;
    }

    /**
     * @param bool $multiple
     * @return $this - Provides Fluent Interface
     */
    public function setMultiple(bool $multiple)
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @param PromiseInterface $promise
     * @return FacetInterface
     */
    private function resolveFacetValuePromise(PromiseInterface $promise): FacetValueInterface
    {
        $value = $promise->wait();
        if (!$value instanceof FacetInterface) {
            throw new \RuntimeException("The resolved promise should return a FacetValueInterface object.");
        }
        return $value;
    }
}