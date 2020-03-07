<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Factory\Message\CreateMessageInput;
use SSupport\Component\Core\Factory\Message\MessageFactoryInterface;
use SSupport\Component\Referee\Gateway\Repository\User\UserRepositoryInterface;

class SendMessage implements SendMessageInterface
{
    protected $messageFactory;
    protected $userRepository;
    protected $eventDispatcher;

    public function __construct(
        MessageFactoryInterface $messageFactory,
        UserRepositoryInterface $userRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->messageFactory = $messageFactory;
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(SendMessageInputInterface $inputDTO): MessageInterface
    {
        $ticket = $inputDTO->getTicket();
        $this->eventDispatcher->dispatch(new BeforeSendMessage($inputDTO));

        $message = $this->messageFactory->create(new CreateMessageInput(
            $inputDTO->getText(),
            $inputDTO->getReferee(),
            $inputDTO->getAttachments()
        ));
        $ticket->addMessage($message);

        $this->eventDispatcher->dispatch(new AfterSendMessage($inputDTO, $message));

        return $message;
    }
}
