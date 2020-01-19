<?php

namespace SSupport\Module\Core;

use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessage as AgentAfterSendMessage;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\AfterCreateTicket;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessage as CustomerAfterSendMessage;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    const DEFAULT_NAME = 'support';
    const DEFAULT_ATTACHMENTS_MIME_TYPE = ['text/plain'];

    public static $name = self::DEFAULT_NAME;

    public $prefix = self::DEFAULT_NAME;

    public $routes = [
        '' => 'ticket/index',
    ];

    public $defaultRoute = 'ticket/index';

    public $controllerNamespace = 'SSupport\Module\Core\Controller';

    public $uploaderListenerEvents = [
        AfterCreateTicket::class,
        CustomerAfterSendMessage::class,
        AgentAfterSendMessage::class,
    ];

    /** @var string|array */
    public $attachmentTypes = 'text/plain';
    public $attachmentsValidationRules = [
        [
            ['files'],
            'file',
            'maxFiles' => 5,
            'mimeTypes' => '',
        ],
    ];
}
