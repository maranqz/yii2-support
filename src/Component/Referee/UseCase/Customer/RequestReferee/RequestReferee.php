<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierInterface;
use SSupport\Component\Referee\Gateway\Repository\RefereeUserRepositoryInterface;

class RequestReferee implements RequestRefereeInterface
{
    protected $userRepository;
    protected $notifier;
    protected $eventDispatcher;

    public function __construct(
        RefereeUserRepositoryInterface $userRepository,
        NotifierInterface $notifier,
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

        $recipients = $this->userRepository->getRecipientsForTicketFromReferee($inputDTO->getTicket());

        $this->notifier->customerRequestReferee($recipients, $inputDTO->getTicket());

        $this->eventDispatcher->dispatch(new AfterRequestReferee($inputDTO));
    }
}
