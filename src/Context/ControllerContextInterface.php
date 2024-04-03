<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Context;

interface ControllerContextInterface
{
    /**
     * Returns a string representation of the resolved controller for the current request
     *
     * @throws \RuntimeException if it's not possible to get a controller for the current request or resolve a controller name for the controller
     */
    public function getController(): string;
}
