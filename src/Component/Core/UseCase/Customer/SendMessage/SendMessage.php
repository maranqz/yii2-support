<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Factory\Message\CreateMessageInput;
use SSupport\Component\Core\Factory\Message\MessageFactoryInterface;
use SSupport\Component\Core\Gateway\Notification\NotifierInterface;
use SSupport\Component\Core\Gateway\Repository\TicketRepositoryInterface;
use SSupport\Component\Core\Gateway\Repository\User\UserRepositoryInterface;

class SendMessage implements SendMessageInterface
{
    protected $ticketRepository;
    protected $messageFactory;
    protected $userRepository;
    protected $notifier;
    protected $eventDispatcher;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        MessageFactoryInterface $messageFactory,
        UserRepositoryInterface $userRepository,
        NotifierInterface $notifier,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->messageFactory = $messageFactory;
        $this->userRepository = $userRepository;
        $this->notifier = $notifier;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(SendMessageInputInterface $inputDTO): MessageInterface
    {
        $this->eventDispatcher->dispatch(new BeforeSendMessage($inputDTO));

        $message = $this->messageFactory->create(new CreateMessageInput(
            $inputDTO->getText(),
            $inputDTO->getCustomer(),
            $inputDTO->getAttachments()
        ));
        $inputDTO->getTicket()->addMessage($message);

        $this->ticketRepository->save($inputDTO->getTicket());

        $recipients = $this->userRepository->getRecipientsForTicketFromCustomer($inputDTO->getTicket());

        $this->notifier->sendMessageFromCustomer($recipients, $inputDTO->getTicket(), $message);

        $this->eventDispatcher->dispatch(new AfterSendMessage($inputDTO, $message));

        return $message;
    }
}
