<?php

namespace OpenCubes\Result\Contract\Column;

use OpenCubes\Common\Options\OptionsAwareInterface;
use OpenCubes\Result\Contract\Sorting\SortingOptionsAwareInterface;

interface ColumnInterface extends SortingOptionsAwareInterface, OptionsAwareInterface
{

    /**
     * Column identifier.
     * @return string
     */
    public function getKey(): string;

    /**
     * Human readable name. Should fallback to getKey().
     * @return string
     */
    public function getName(): string;

    /**
     * getName() alias.
     * @return string
     */
    public function __toString(): string;

}