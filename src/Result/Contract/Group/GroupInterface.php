<?php

namespace OpenCubes\Result\Contract\Group;

use OpenCubes\Common\Options\OptionsAwareInterface;

interface GroupInterface extends OptionsAwareInterface
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
     * @return bool
     */
    public function isApplied(): bool;

    /**
     * getName() alias.
     * @return string
     */
    public function __toString(): string;

}