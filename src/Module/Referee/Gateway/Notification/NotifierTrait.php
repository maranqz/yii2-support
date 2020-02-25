<?php

namespace SSupport\Module\Referee\Gateway\Notification;

use yii\mail\MailerInterface;

/**
 * @property MailerInterface $mailer
 * @property string          $emailFrom
 * @property string          $rootPath
 */
trait NotifierTrait
{
    /** @TODO transfer to own interface/class */
    protected function sendMessage($path, iterable $recipients, $subject, $params)
    {
        $message = $this->mailer->compose($this->getView($path), $params)
            ->setFrom($this->emailFrom)
            ->setSubject($subject);

        foreach ($recipients as $recipient) {
            $message->setTo($recipient->getEmail())
                ->send();
        }
    }

    protected function getPath($name)
    {
        return $this->rootPath.$name.'/';
    }

    protected function getView($path)
    {
        return [
            'html' => $path.'/html',
            'text' => $path.'/text',
        ];
    }
}
