<?php

declare(strict_types=1);

namespace Setono\SEOBundle\Context;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ControllerContext implements ControllerContextInterface, EventSubscriberInterface
{
    private mixed $controller = null;

    private ?string $controllerName = null;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['setController', -900],
        ];
    }

    public function setController(ControllerEvent $event): void
    {
        $this->controller = $event->getController();
    }

    public function getController(): string
    {
        if (null === $this->controllerName) {
            if (null === $this->controller || !is_callable($this->controller, false, $callableName)) {
                throw new \RuntimeException('The controller has not been resolved yet from the current request or it is an invalid callable');
            }

            $this->controllerName = $callableName;
        }

        return $this->controllerName;
    }
}
