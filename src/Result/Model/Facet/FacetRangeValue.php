<?php

namespace OpenCubes\Result\Model\Facet;

class FacetRangeValue extends FacetValue
{

    private $left, $right;

    /**
     * @return mixed
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param mixed $left
     * @return $this - Provides Fluent Interface
     */
    public function setLeft($left)
    {
        $this->left = $left;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param mixed $right
     * @return $this - Provides Fluent Interface
     */
    public function setRight($right)
    {
        $this->right = $right;
        return $this;
    }

}