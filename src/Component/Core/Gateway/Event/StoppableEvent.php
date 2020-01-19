<?php

namespace SSupport\Component\Core\Gateway\Event;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * source {@see https://github.com/symfony/event-dispatcher-contracts/blob/v2.0.0/Event.php}.
 */
class StoppableEvent implements StoppableEventInterface
{
    private $propagationStopped = false;

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
