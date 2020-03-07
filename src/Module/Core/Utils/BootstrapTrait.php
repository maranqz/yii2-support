<?php

namespace SSupport\Module\Core\Utils;

use Psr\EventDispatcher\EventDispatcherInterface;

trait BootstrapTrait
{
    protected function initListeners()
    {
        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $this->make(EventDispatcherInterface::class);

        foreach ($this->getModule()->listeners as $event => $listeners) {
            if (isset($listeners[0]) && !\is_callable($listeners[0])) {
                $listeners = [$listeners];
            }

            foreach ($listeners as $listener) {
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
