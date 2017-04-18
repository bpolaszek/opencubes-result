<?php

namespace OpenCubes\Result\Model;

use OpenCubes\Common\Options\OptionsAwareTrait;
use OpenCubes\Result\Contract\ResultInterface;
use OpenCubes\Result\Model\Column\ColumnsAwareTrait;
use OpenCubes\Result\Model\Facet\FacetsAwareTrait;
use OpenCubes\Result\Model\Group\GroupsAwareTrait;
use OpenCubes\Result\Model\Sorting\SortingOptionsAwareTrait;
use GuzzleHttp\Promise\PromiseInterface;

class Result implements \IteratorAggregate, ResultInterface
{
    use SortingOptionsAwareTrait,
        ColumnsAwareTrait,
        OptionsAwareTrait,
        FacetsAwareTrait,
        GroupsAwareTrait;

    /**
     * @var \Traversable|array
     */
    private $items;

    /**
     * @var int
     */
    private $numFound;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $length;

    /**
     * @inheritdoc
     */
    public function getItems(): iterable
    {
        if ($this->items instanceof PromiseInterface) {
            $this->setItems($this->items->wait());
        }
        return $this->items;
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        if (null !== $items && !is_iterable($items) && !$items instanceof PromiseInterface) {
            throw new \InvalidArgumentException('Items should be array or Traversable.');
        }
        $this->items = $items;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        if (null === $this->items) {
            return new \ArrayIterator([]);
        }
        return is_array($this->items) ? new \ArrayIterator($this->items) : $this->items;
    }

    /**
     * @inheritdoc
     */
    public function getNumFound(): ?int
    {
        if ($this->numFound instanceof PromiseInterface) {
            $this->setNumFound($this->numFound->wait());
        }
        return $this->numFound;
    }

    /**
     * @param $numFound
     * @return $this
     */
    public function setNumFound($numFound)
    {
        if (!is_numeric($numFound) && !$numFound instanceof PromiseInterface) {
            throw new \InvalidArgumentException('Expecting numeric value.');
        }
        $this->numFound = $numFound;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getOffset(): ?int
    {
        if ($this->offset instanceof PromiseInterface) {
            $this->setOffset($this->offset->wait());
        }
        return $this->offset;
    }

    /**
     * @param $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        if (!is_numeric($offset) && !$offset instanceof PromiseInterface) {
            throw new \InvalidArgumentException('Expecting numeric value.');
        }
        $this->offset = $offset;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLength(): ?int
    {
        if ($this->length instanceof PromiseInterface) {
            $this->setLength($this->length->wait());
        }
        return $this->length;
    }

    /**
     * @param $length
     * @return $this
     */
    public function setLength($length)
    {
        if (!is_numeric($length) && !$length instanceof PromiseInterface) {
            throw new \InvalidArgumentException('Expecting numeric value.');
        }
        $this->length = $length;
        return $this;
    }

    /**
     * Binds all column sorting options to the current resultset.
     */
    public function bindColumnSortingOptions(): void
    {
        $this->sortingOptions = [];
        /** @var \OpenCubes\Result\Contract\Column\ColumnInterface[] $columns */
        $columns = $this->getColumns();
        foreach ($columns AS $column) {
            foreach ($column->getSortingOptions() AS $sortingOption) {
                $this->sortingOptions[] = $sortingOption;
            }
        }
    }

}