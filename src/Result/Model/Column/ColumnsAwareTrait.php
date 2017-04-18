<?php

namespace OpenCubes\Result\Model\Column;

use OpenCubes\Result\Contract\Column\ColumnInterface;
use GuzzleHttp\Promise\PromiseInterface;

trait ColumnsAwareTrait
{
    /**
     * @var array|ColumnInterface[]
     */
    protected $columns = [];

    /**
     * @param $columns
     * @return $this - Provides fluent interface
     */
    public function setColumns($columns)
    {
        if ($columns instanceof PromiseInterface) {
            $this->columns = $columns;
        }
        else {
            $this->columns = (function (ColumnInterface ...$columns) {
                return $columns;
            })(...$columns);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getColumns(): iterable
    {
        return $this->columns instanceof PromiseInterface ? $this->setColumns($this->columns->wait())->columns : $this->columns;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasColumn(string $key): bool
    {
        $columns = $this->getColumns();
        foreach ($columns AS $column) {
            if ($key === $column->getKey()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $key
     * @return ColumnInterface|null
     */
    public function getColumn(string $key): ?ColumnInterface
    {
        $columns = $this->getColumns();
        foreach ($columns AS $column) {
            if ($key === $column->getKey()) {
                return $column;
            }
        }
        return null;
    }
}