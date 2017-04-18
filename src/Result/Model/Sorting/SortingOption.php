<?php

namespace OpenCubes\Result\Model\Sorting;

use OpenCubes\Common\Options\OptionsAwareTrait;
use OpenCubes\Result\Contract\Sorting\SortingOptionInterface;

class SortingOption implements SortingOptionInterface
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
     * @var array
     */
    private $availableDirections = [
        self::SORT_ASC,
        self::SORT_DESC,
    ];

    /**
     * @var string
     */
    private $appliedDirection;

    /**
     * SortingOption constructor.
     * @param string $key
     * @param string $name
     * @param array $availableDirections
     * @param string $appliedDirection
     */
    public function __construct(string $key, string $name = null, array $availableDirections = [self::SORT_ASC, self::SORT_DESC], $appliedDirection = null)
    {
        $this->key                 = $key;
        $this->name                = $name;
        $this->setAvailableDirections($availableDirections);
        $this->setAppliedDirection($appliedDirection);
    }

    /**
     * @param string $key
     * @return $this - Provides Fluent Interface
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
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
    public function setName($name)
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
     * @param array $availableDirections
     * @return $this - Provides Fluent Interface
     */
    public function setAvailableDirections($availableDirections)
    {
        foreach ($availableDirections AS $availableDirection) {
            if (!in_array($availableDirection, [self::SORT_ASC, self::SORT_DESC])) {
                throw new \InvalidArgumentException("Available directions must be asc or desc.");
            }
        }
        $this->availableDirections = $availableDirections;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAvailableDirections(): array
    {
        return $this->availableDirections;
    }

    /**
     * @inheritDoc
     */
    public function canSortAsc(): bool
    {
        return in_array(self::SORT_ASC, $this->getAvailableDirections());
    }

    /**
     * @inheritDoc
     */
    public function canSortDesc(): bool
    {
        return in_array(self::SORT_DESC, $this->getAvailableDirections());
    }

    /**
     * @inheritDoc
     */
    public function isApplied(): bool
    {
        return null !== $this->appliedDirection;
    }

    /**
     * @param string $appliedDirection
     * @return $this - Provides Fluent Interface
     */
    public function setAppliedDirection($appliedDirection)
    {
        if (null !== $appliedDirection && !in_array($appliedDirection, [self::SORT_ASC, self::SORT_DESC])) {
            throw new \InvalidArgumentException("Applied direction must be asc or desc.");
        }
        $this->appliedDirection = $appliedDirection;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAppliedDirection(): ?string
    {
        return $this->appliedDirection;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getName();
    }

}