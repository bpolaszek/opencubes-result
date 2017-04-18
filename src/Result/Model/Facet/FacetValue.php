<?php

namespace OpenCubes\Result\Model\Facet;

use GuzzleHttp\Promise\PromiseInterface;
use OpenCubes\Common\Options\OptionsAwareTrait;
use OpenCubes\Result\Contract\Facet\FacetValueInterface;

class FacetValue implements FacetValueInterface
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
     * @var int
     */
    private $count = 0;

    /**
     * @var bool
     */
    private $applied = false;

    /**
     * FacetValue constructor.
     * @param string $key
     * @param $name
     * @param bool $applied
     * @param int $count
     */
    public function __construct(string $key, string $name = null, $count = null, bool $applied = false)
    {
        $this->key     = $key;
        $this->name    = $name;
        $this->setCount($count);
        $this->applied = $applied;
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
     * @param int $count
     * @return $this - Provides Fluent Interface
     */
    public function setCount($count)
    {
        if (!($count instanceof PromiseInterface || is_int($count))) {
            throw new \InvalidArgumentException("Count must be either a PromiseInterface or an integer.");
        }
        $this->count = $count;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        if ($this->count instanceof PromiseInterface) {
            $this->setCount($this->count->wait());
        }
        return $this->count;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->getCount();
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
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName();
    }
}