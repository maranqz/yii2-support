<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Factory\FactoryInterface;
use SSupport\Component\Core\Gateway\Notification\NotifierInterface;
use SSupport\Component\Core\Gateway\Repository\Message\CreateMessageRepositoryInput;
use SSupport\Component\Core\Gateway\Repository\Message\MessageRepositoryInterface;
use SSupport\Component\Core\Gateway\Repository\TicketRepositoryInterface;
use SSupport\Component\Core\Gateway\Repository\UserRepositoryInterface;

class CreateTicket implements CreateTicketInterface
{
    protected $ticketRepository;
    protected $userRepository;
    protected $messageRepository;
    protected $notifier;
    protected $ticketFactory;
    protected $eventDispatcher;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        UserRepositoryInterface $userRepository,
        MessageRepositoryInterface $messageRepository,
        NotifierInterface $notifier,
        FactoryInterface $ticketFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->userRepository = $userRepository;
        $this->messageRepository = $messageRepository;
        $this->notifier = $notifier;
        $this->ticketFactory = $ticketFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateTicketInputInterface $ticketInput): TicketInterface
    {
        $this->eventDispatcher->dispatch(new BeforeCreateTicket($ticketInput));

        $ticket = $this->getTicket();
        $ticket->setSubject($ticketInput->getSubject())
            ->setCustomer($ticketInput->getCustomer());

        $this->ticketRepository->save($ticket);

        $agents = $this->userRepository->getAgentsForUnsignedTicket($ticket);

        $message = $this->messageRepository->createAndSave(new CreateMessageRepositoryInput(
            $ticketInput->getText(),
            $ticketInput->getCustomer(),
            $ticketInput->getAttachments()
        ));

        $ticket->addMessage($message);

        $this->notifier->createTicket($agents, $ticket, $message);

        $this->eventDispatcher->dispatch(new AfterCreateTicket($ticket));

        return $ticket;
    }

    /** @return TicketInterface */
    protected function getTicket()
    {
        return $this->ticketFactory->createNew();
    }
}
