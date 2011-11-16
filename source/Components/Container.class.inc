<?php

namespace Woody\Components;

/**
 * This interface defines methods for adding and removing components to a container component, e.g. a window, a frame, or a tab control.
 */
interface Container
{
    /**
     * This method adds a component to a container.
     *
     * @param Component $component the component to add
     * @return $this
     */
    function add(Component $component);

    /**
     * This method removes a component from a container.
     *
     * @param Component $component the component to remove
     * @return $this
     */
    function remove(Component $component);
}