<?php

namespace OpenCubes\Result\Model\Item;

use OpenCubes\Common\Options\OptionsAwareInterface;
use OpenCubes\Common\Options\OptionsAwareTrait;

class Item implements OptionsAwareInterface
{
    use OptionsAwareTrait;

    /**
     * @var int|string
     */
    private $key;

    /**
     * @var mixed
     */
    private $data;

    /**
     * Item constructor.
     * @param int|string $key
     * @param mixed $data
     */
    public function __construct($key, $data)
    {
        $this->key  = $key;
        $this->data = $data;
    }

    /**
     * @return int|string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param int|string $key
     * @return $this - Provides Fluent Interface
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return $this - Provides Fluent Interface
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

}