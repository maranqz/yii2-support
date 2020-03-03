<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Gateway\Repository\TicketRepositoryInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RefereeRequestedException;

class SetTimeoutRequest implements SetTimeoutRequestInterface
{
    protected $ticketRepository;
    protected $eventDispatcher;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(SetTimeoutRequestInputInterface $inputDTO)
    {
        $timeoutRequest = $inputDTO->getTimeoutRequest();
        if (!empty($timeoutRequest->alreadyTimeoutRequest())) {
            throw new SetTimeoutRequestException();
        }

        $ticket = $timeoutRequest->getTicket();
        if (!empty($ticket->hasReferee())) {
            throw new RefereeRequestedException();
        }

        $this->eventDispatcher->dispatch(new BeforeSetTimeoutRequest($inputDTO));

        $timeoutRequest->setTimeoutRequest(
            $inputDTO->getTimeout(),
            $inputDTO->getRequester()
        );
        $this->ticketRepository->save($ticket);

        $this->eventDispatcher->dispatch(new AfterSetTimeoutRequest($inputDTO));
    }
}
