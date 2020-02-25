<?php

namespace SSupport\Module\Referee\Gateway\Notification;

use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessageInterface as AgentAfterSendMessageInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessageInterface as CustomerAfterSendMessageInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Referee\Gateway\Repository\User\UserRepositoryInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\AfterRequestReferee;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\AfterSendMessageInterface;
use SSupport\Module\Core\Gateway\Highlighting\HighlighterInterface;
use yii\mail\MailerInterface;

class NotifierListener implements NotifierListenerInterface
{
    use NotifierTrait;

    const DEFAULT_PATH = '@SSupport/Module/Referee/Gateway/Notification/views/';

    /** @var MailerInterface */
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

    public function sendMessageFromReferee(AfterSendMessageInterface $event)
    {
        $ticket = $event->getInput()->getTicket();
        $message = $event->getMessage();
        $recipients = $this->userRepository->getRecipientsFromReferee($ticket);

        $this->highlighter->highlight($ticket, [$message->getSender()]);

        $this->sendMessage(
            $this->getPath(__FUNCTION__),
            $recipients,
            $ticket->getSubject(),
            [
                'ticket' => $ticket,
                'message' => $message,
            ]
        );
    }

    public function sendMessageFromAgent(AgentAfterSendMessageInterface $event)
    {
        $ticket = $event->getInput()->getTicket();
        if (empty($ticket->getReferee())) {
            return;
        }

        $message = $event->getMessage();
        $recipients = [$ticket->getReferee()];

        $this->sendMessage(
            $this->getPath(__FUNCTION__),
            $recipients,
            $ticket->getSubject(),
            [
                'ticket' => $ticket,
                'message' => $message,
            ]
        );
    }

    public function sendMessageFromCustomer(CustomerAfterSendMessageInterface $event)
    {
        $ticket = $event->getInput()->getTicket();
        if (empty($ticket->getReferee())) {
            return;
        }

        $ticket = $event->getInput()->getTicket();
        $message = $event->getMessage();
        $recipients = [$ticket->getReferee()];

        $this->sendMessage(
            $this->getPath(__FUNCTION__),
            $recipients,
            $ticket->getSubject(),
            [
                'ticket' => $ticket,
                'message' => $message,
            ]
        );
    }

    public function customerRequestRefereeForReferee(AfterRequestReferee $event)
    {
        $ticket = $event->getInput()->getTicket();
        $recipients = [$ticket->getReferee()];

        $this->highlighter->highlight($ticket, [$event->getInput()->getRequester()]);

        $this->sendMessage(
            $this->getPath(__FUNCTION__),
            $recipients,
            $ticket->getSubject(),
            [
                'ticket' => $ticket,
            ]
        );
    }
}
