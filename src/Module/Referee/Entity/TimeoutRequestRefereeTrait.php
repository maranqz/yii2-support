<?php

namespace SSupport\Module\Referee\Entity;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

/**
 * @property int $referee_timeout timestamp
 */
trait TimeoutRequestRefereeTrait
{
    public function setTimeoutRequest($timeout, UserInterface $requester = null)
    {
        $this->referee_timeout = time() + $timeout;

        return $this;
    }

    public function getTimeoutRequest()
    {
        return $this->referee_timeout;
    }

    public function getRemainingTimeoutRequest()
    {
        $remaining = $this->referee_timeout - time();

        return $remaining > 0 ? $remaining : 0;
    }

    public function alreadyTimeoutRequest(): bool
    {
        return $this->referee_timeout > 0;
    }

    public function isTimeoutRequestUp(): bool
    {
        if (empty($this->referee_timeout)) {
            return false;
        }

        return $this->referee_timeout < time();
    }

    public function getTicket(): RefereeTicketInterface
    {
        return $this;
    }
}
