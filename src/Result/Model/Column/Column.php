<?php

namespace OpenCubes\Result\Model\Column;

use OpenCubes\Common\Options\OptionsAwareTrait;
use OpenCubes\Result\Contract\Column\ColumnInterface;
use OpenCubes\Result\Model\Sorting\SortingOptionsAwareTrait;

class Column implements ColumnInterface
{
    use SortingOptionsAwareTrait,
        OptionsAwareTrait;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $name;

    /**
     * Column constructor.
     * @param string $key
     * @param string $name
     */
    public function __construct(string $key, string $name = null)
    {
        $this->key  = $key;
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
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
    public function __toString(): string
    {
        return $this->getName();
    }
}