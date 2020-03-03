<?php

namespace SSupport\Module\Core\Gateway\Notification;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Core\Gateway\Repository\User\UserRepositoryInterface;
use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessageInterface as AgentAfterSendMessageInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\AfterCreateTicketInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessageInterface as CustomerAfterSendMessageInterface;
use SSupport\Module\Core\Gateway\Highlighting\HighlighterInterface;
use SSupport\Module\Referee\Gateway\Notification\NotifierTrait;
use yii\mail\MailerInterface;

class NotifierListener implements NotifierListenerInterface
{
    use NotifierTrait;

    const DEFAULT_PATH = '@SSupport/Module/Core/Gateway/Notification/views/';

    protected $mailer;
    protected $userRepository;
    protected $highlighter;
    protected $emailFrom;
    protected $rootPath;

    public function __construct(
        MailerInterface $mailer,
        UserRepositoryInterface $userRepository,
        HighlighterInterface $highlighter,
        $emailFrom,
        $rootPath = self::DEFAULT_PATH
    ) {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
        $this->highlighter = $highlighter;
        $this->emailFrom = $emailFrom;
        $this->rootPath = $rootPath;
    }

    public function newTicket(AfterCreateTicketInterface $event)
    {
        $ticket = $event->getTicket();
        $messages = $ticket->getMessages();
        $message = end($messages);
        $recipients = $this->userRepository->getRecipientsForNewTicket($ticket);

        $this->highlighter->highlight($ticket, [$message->getSender()]);

        $this->sendMessage(
            $this->getPath(__FUNCTION__),
            $recipients,
            $ticket->getSubject(),
            $this->getParams($ticket, $message)
        );
    }

    public function sendMessageFromAgent(AgentAfterSendMessageInterface $event)
    {
        $ticket = $event->getInput()->getTicket();
        $message = $event->getMessage();
        $recipients = $this->userRepository->getRecipientsFromAgent($ticket);

        $this->highlighter->highlight($ticket, [$message->getSender()]);

        $this->sendMessage(
            $this->getPath(__FUNCTION__),
            $recipients,
            $ticket->getSubject(),
            $this->getParams($ticket, $message)
        );
    }

    public function sendMessageFromCustomer(CustomerAfterSendMessageInterface $event)
    {
        $ticket = $event->getInput()->getTicket();
        $message = $event->getMessage();
        $recipients = $this->userRepository->getRecipientsFromCustomer($ticket);

        $this->highlighter->highlight($ticket, [$message->getSender()]);

        $this->sendMessage(
            $this->getPath(__FUNCTION__),
            $recipients,
            $ticket->getSubject(),
            $this->getParams($ticket, $message)
        );
    }

    protected function getParams(TicketInterface $ticket, MessageInterface $message)
    {
        return [
            'ticket' => $ticket,
            'message' => $message,
        ];
    }
}
