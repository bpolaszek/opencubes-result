<?php

namespace OpenCubes\Result\Contract\Group;

interface GroupsAwareInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function hasGroup(string $key): bool;

    /**
     * @param string $key
     * @return null|GroupInterface
     */
    public function getGroup(string $key): ?GroupInterface;

    /**
     * @return iterable|GroupInterface[]
     */
    public function getGroups(): iterable;

}