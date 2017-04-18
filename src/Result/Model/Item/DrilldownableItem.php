<?php

namespace OpenCubes\Result\Model\Item;

use OpenCubes\Result\Contract\Group\GroupsAwareInterface;
use OpenCubes\Result\Model\Group\GroupsAwareTrait;

class DrilldownableItem extends Item implements GroupsAwareInterface
{
    use GroupsAwareTrait;
}