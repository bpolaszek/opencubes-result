<?php

namespace OpenCubes\Result\Model\Group;

use GuzzleHttp\Promise\PromiseInterface;
use OpenCubes\Result\Contract\Group\GroupInterface;

trait GroupsAwareTrait
{
    /**
     * @var array
     */
    private $groups = [];

    /**
     * @inheritDoc
     */
    public function hasGroup(string $key): bool
    {
        /** @var GroupInterface[] $groups */
        $groups = iterable_to_array($this->getGroups());
        foreach ($groups AS $group) {
            if ($key === $group->getKey()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getGroup(string $key): ?GroupInterface
    {
        /** @var GroupInterface[] $groups */
        $groups = iterable_to_array($this->getGroups());
        foreach ($groups AS $group) {
            if ($key === $group->getKey()) {
                return $group;
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getGroups(): iterable
    {
        if ($this->groups instanceof PromiseInterface) {
            $this->setGroups($this->groups->wait());
            return $this->getGroups();
        }
        foreach ($this->groups AS $key => &$group) {
            if (!($group instanceof PromiseInterface || $group instanceof GroupInterface)) {
                throw new \InvalidArgumentException("A group should be either a PromiseInterface or a GroupInterface");
            }
            if ($group instanceof PromiseInterface) {
                $group = $this->resolveGroupPromise($group);
            }
            yield $key => $group;
        }
    }

    /**
     * @param $groups
     * @return $this
     */
    public function setGroups($groups)
    {
        if (null === $groups) {
            $this->groups = [];
        }
        elseif ($groups instanceof PromiseInterface) {
            $this->groups = $groups;
        }
        else {
            if (!is_iterable($groups)) {
                throw new \InvalidArgumentException("Groups should be iterable");
            }
            $this->groups = $groups;
        }
        return $this;
    }

    /**
     * @param PromiseInterface $promise
     * @return GroupInterface
     */
    private function resolveGroupPromise(PromiseInterface $promise): GroupInterface
    {
        $group = $promise->wait();
        if (!$group instanceof GroupInterface) {
            throw new \RuntimeException("The resolved promise should return a GroupInterface object.");
        }
        return $group;
    }
}