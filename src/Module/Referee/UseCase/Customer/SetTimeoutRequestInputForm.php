<?php

namespace SSupport\Module\Referee\UseCase\Customer;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\TimeoutRequestRefereeInterface;
use SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest\SetTimeoutRequestInputInterface;
use yii\base\Model;

class SetTimeoutRequestInputForm extends Model implements SetTimeoutRequestInputInterface
{
    protected $timeoutRequest;
    protected $timeout;
    protected $requester;

    public function setTimeoutRequest(TimeoutRequestRefereeInterface $timeoutRequest)
    {
        $this->timeoutRequest = $timeoutRequest;

        return $this;
    }

    public function getTimeoutRequest(): TimeoutRequestRefereeInterface
    {
        return $this->timeoutRequest;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function setRequester(UserInterface $requester = null)
    {
        $this->requester = $requester;

        return $this;
    }

    public function getRequester(): UserInterface
    {
        return $this->requester;
    }
}
