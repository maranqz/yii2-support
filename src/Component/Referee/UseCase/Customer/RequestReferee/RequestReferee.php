<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierInterface;
use SSupport\Component\Referee\Gateway\Repository\UserRepositoryInterface;

class RequestReferee implements RequestRefereeInterface
{
    protected $userRepository;
    protected $notifier;
    protected $eventDispatcher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        NotifierInterface $notifier,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->notifier = $notifier;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(RequestRefereeInputInterface $inputDTO)
    {
        $this->eventDispatcher->dispatch(new BeforeRequestReferee($inputDTO));

        $inputDTO->getTicket()->assignReferee($inputDTO->getReferee());

        $recipients = $this->userRepository->getRecipientsForTicketFromReferee($inputDTO->getTicket());

        $this->notifier->customerRequestReferee($recipients, $inputDTO->getTicket());

        $this->eventDispatcher->dispatch(new AfterRequestReferee());
    }
}
