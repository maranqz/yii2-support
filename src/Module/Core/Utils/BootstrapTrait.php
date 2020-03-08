<?php

namespace SSupport\Module\Core\Utils;

use Psr\EventDispatcher\EventDispatcherInterface;

trait BootstrapTrait
{
    protected function initListeners($defaultListeners = [])
    {
        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $this->make(EventDispatcherInterface::class);

        $listeners = array_merge($defaultListeners, $this->getModule()->listeners);

        foreach ($listeners as $event => $actionListeners) {
            if (isset($actionListeners[0]) && !\is_callable($actionListeners[0])) {
                $actionListeners = [$actionListeners];
            }

            foreach ($actionListeners as $listener) {
                if (isset($listener[0]) && \is_string($listener[0])) {
                    $listener[0] = function (...$args) use ($listener) {
                        return $this->make($listener[0]);
                    };
                }

                $dispatcher->addListener($event, $listener);
            }
        }
    }
}
