<?php

namespace Support\Component\Referee\UseCase\Referee\SendMessage;

use Psr\EventDispatcher\EventDispatcherInterface;
use Support\Component\Core\Entity\MessageInterface;
use Support\Component\Core\Gateway\Repository\Message\CreateMessageRepositoryInput;
use Support\Component\Core\Gateway\Repository\Message\MessageRepositoryInterface;
use Support\Component\Referee\Gateway\Notification\NotifierInterface;
use Support\Component\Referee\Gateway\Repository\UserRepositoryInterface;

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
            $inputDTO->getReferee(),
            $inputDTO->getAttachments(),
            false
        ));

        $recipients = $this->userRepository->getRecipientsForTicketFromReferee($inputDTO->getTicket());

        $this->notifier->createMessageFromReferee($recipients, $inputDTO->getTicket(), $message);

        $this->eventDispatcher->dispatch(new AfterSendMessage($message));

        return $message;
    }
}
