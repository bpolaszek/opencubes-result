<?php

namespace OpenCubes\Result\Contract;

use OpenCubes\Common\Options\OptionsAwareInterface;
use OpenCubes\Result\Contract\Facet\FacetsAwareInterface;
use OpenCubes\Result\Contract\Group\GroupsAwareInterface;
use OpenCubes\Result\Contract\Sorting\SortingOptionsAwareInterface;

interface ResultInterface extends \Traversable, OptionsAwareInterface, FacetsAwareInterface, GroupsAwareInterface, SortingOptionsAwareInterface
{

    #################
    #   COLUMNS     #
    #################

    /**
     * @return Column\ColumnInterface[]
     */
    public function getColumns(): iterable;

    #############
    #   ITEMS   #
    #############

    /**
     * Iterate over the resultset.
     * @return \Traversable|array|iterable|null
     */
    public function getItems(): iterable;


    #####################
    #   PAGINATION      #
    #####################

    /**
     * @return int|null
     */
    public function getNumFound(): ?int;

    /**
     * @return int|null
     */
    public function getOffset(): ?int;

    /**
     * @return int|null
     */
    public function getLength(): ?int;


}