<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Factory\Message\CreateMessageInput;
use SSupport\Component\Core\Factory\Message\MessageFactoryInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Referee\Gateway\Repository\User\UserRepositoryInterface;

class SendMessage implements SendMessageInterface
{
    protected $messageFactory;
    protected $userRepository;
    protected $notifier;
    protected $eventDispatcher;

    public function __construct(
        MessageFactoryInterface $messageFactory,
        UserRepositoryInterface $userRepository,
        NotifierListenerInterface $notifier,
        EventDispatcherInterface $eventDispatcher
    ) {
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
            $inputDTO->getReferee(),
            $inputDTO->getAttachments()
        ));

        $recipients = $this->userRepository->getRecipientsForTicketFromReferee($inputDTO->getTicket());

        $this->notifier->sendMessageFromReferee($recipients, $inputDTO->getTicket(), $message);

        $this->eventDispatcher->dispatch(new AfterSendMessage($inputDTO, $message));

        return $message;
    }
}
