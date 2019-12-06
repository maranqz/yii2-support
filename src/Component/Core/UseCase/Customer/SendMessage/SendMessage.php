<?php

namespace Support\Component\Core\UseCase\Customer\SendMessage;

use Psr\EventDispatcher\EventDispatcherInterface;
use Support\Component\Core\Entity\MessageInterface;
use Support\Component\Core\Gateway\Notification\NotifierInterface;
use Support\Component\Core\Gateway\Repository\Message\CreateMessageRepositoryInput;
use Support\Component\Core\Gateway\Repository\Message\MessageRepositoryInterface;
use Support\Component\Core\Gateway\Repository\UserRepositoryInterface;

class SendMessage implements SendMessageInterface
{
    protected $messageRepository;
    protected $userRepository;
    protected $notifier;
    protected $eventDispatcher;

    public function __construct(
        MessageRepositoryInterface $messageRepository,
        UserRepositoryInterface $userRepository,
        NotifierInterface $notifier,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
        $this->notifier = $notifier;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(SendMessageInputInterface $inputDTO): MessageInterface
    {
        $this->eventDispatcher->dispatch(new BeforeSendMessage($inputDTO));

        $message = $this->messageRepository->createAndSave(new CreateMessageRepositoryInput(
            $inputDTO->getText(),
            $inputDTO->getCustomer(),
            $inputDTO->getAttachments()
        ));

        $recipients = $this->userRepository->getRecipientsForTicketFromCustomer($inputDTO->getTicket());

        $this->notifier->createMessageFromCustomer($recipients, $inputDTO->getTicket(), $message);

        $this->eventDispatcher->dispatch(new AfterSendMessage($message));

        return $message;
    }
}
