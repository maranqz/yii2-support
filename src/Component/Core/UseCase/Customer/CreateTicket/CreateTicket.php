<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Factory\FactoryInterface;
use SSupport\Component\Core\Factory\Message\CreateMessageInput;
use SSupport\Component\Core\Factory\Message\MessageFactoryInterface;
use SSupport\Component\Core\Gateway\Repository\TicketRepositoryInterface;
use SSupport\Component\Core\Gateway\Repository\User\UserRepositoryInterface;

class CreateTicket implements CreateTicketInterface
{
    protected $ticketRepository;
    protected $userRepository;
    protected $messageFactory;
    protected $ticketFactory;
    protected $eventDispatcher;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        UserRepositoryInterface $userRepository,
        MessageFactoryInterface $messageFactory,
        FactoryInterface $ticketFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->userRepository = $userRepository;
        $this->messageFactory = $messageFactory;
        $this->ticketFactory = $ticketFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateTicketInputInterface $ticketInput): TicketInterface
    {
        $this->eventDispatcher->dispatch(new BeforeCreateTicket($ticketInput));

        $ticket = $this->getTicket();
        $ticket->setSubject($ticketInput->getSubject())
            ->setCustomer($ticketInput->getCustomer());

        foreach ($this->userRepository->getDefaultAgentsForTicket($ticket) as $agent) {
            $ticket->assign($agent);
        }

        $message = $this->messageFactory->create(new CreateMessageInput(
            $ticketInput->getText(),
            $ticketInput->getCustomer(),
            $ticketInput->getAttachments()
        ));
        $ticket->addMessage($message);

        $this->ticketRepository->save($ticket);

        $this->eventDispatcher->dispatch(new AfterCreateTicket($ticketInput, $ticket));

        return $ticket;
    }

    /** @return TicketInterface */
    protected function getTicket()
    {
        return $this->ticketFactory->createNew();
    }
}
