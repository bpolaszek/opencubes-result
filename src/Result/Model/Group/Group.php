<?php

namespace OpenCubes\Result\Model\Group;

use OpenCubes\Common\Options\OptionsAwareTrait;
use OpenCubes\Result\Contract\Group\GroupInterface;

class Group implements GroupInterface
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
     * @var bool
     */
    private $applied = false;

    /**
     * Group constructor.
     * @param $key
     * @param string $name
     * @param bool $applied
     */
    public function __construct(string $key, string $name = null, bool $applied = false)
    {
        $this->key     = $key;
        $this->name    = $name;
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