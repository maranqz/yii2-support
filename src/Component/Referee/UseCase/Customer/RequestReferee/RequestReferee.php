<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Referee\Gateway\Repository\User\UserRepositoryInterface;

class RequestReferee implements RequestRefereeInterface
{
    protected $userRepository;
    protected $notifier;
    protected $eventDispatcher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        NotifierListenerInterface $notifier,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->notifier = $notifier;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(RequestRefereeInputInterface $inputDTO)
    {
        if (!empty($inputDTO->getTicket()->getReferee())) {
            throw new RefereeRequestedException();
        }

        $this->eventDispatcher->dispatch(new BeforeRequestReferee($inputDTO));

        $inputDTO->getTicket()->assignReferee(
            $this->userRepository->getRefereeForTicket($inputDTO->getTicket()),
            $inputDTO->getRequester()
        );

        $this->eventDispatcher->dispatch(new AfterRequestReferee($inputDTO));
    }
}
