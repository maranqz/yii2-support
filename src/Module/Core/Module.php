<?php

namespace SSupport\Module\Core;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessage as AgentAfterSendMessage;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\AfterCreateTicket;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessage as CustomerAfterSendMessage;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Resource\config\GridView\AgentGridViewSettingsInterface;
use SSupport\Module\Core\Resource\config\GridView\CustomerGridViewSettingsInterface;
use SSupport\Module\Core\Utils\ModuleTrait;
use Yii;
use yii\base\Module as BaseModule;
use yii\helpers\Url;

class Module extends BaseModule
{
    use ModuleTrait;

    const DEFAULT_NAME = 'support';
    const DEFAULT_ATTACHMENTS_MIME_TYPE = ['text/plain'];

    const AGENT_ROLE = 'support-agent';
    const CUSTOMER_ROLE = 'support-customer';

    const TICKET_ID = 'ticketId';

    const LOCAL_ATTACHMENTS_DIRECTORY = '/support/attachment/';

    public static $name = self::DEFAULT_NAME;

    public $prefix = self::DEFAULT_NAME;

    public $routes = [
        '' => 'ticket/index',
    ];

    public $defaultRoute = 'ticket/index';

    public $controllerNamespace = 'SSupport\Module\Core\Controller';

    public $emailFrom;

    public $isGuestCreateTicket = false;

    public $uploaderListenerEvents = [
        AfterCreateTicket::class,
        CustomerAfterSendMessage::class,
        AgentAfterSendMessage::class,
    ];

    public $listeners = [
        AfterCreateTicket::class => [NotifierListenerInterface::class, 'newTicket'],
        AgentAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromAgent'],
        CustomerAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromCustomer'],
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
    /** @TODO refactoring */
    public $attachmentWebPath = self::LOCAL_ATTACHMENTS_DIRECTORY;
    public $attachmentPath = '@webroot'.self::LOCAL_ATTACHMENTS_DIRECTORY;

    /** @var callable */
    public $viewDetailConfig = [self::class, 'getViewDetailConfigDefault'];

    public function getViewDetailConfig(TicketInterface $ticket): iterable
    {
        return ($this->viewDetailConfig)($ticket);
    }

    public static function getViewDetailConfigDefault(TicketInterface $ticket): iterable
    {
        return [
            'model' => $ticket,
            'attributes' => [
                'nickname' => [
                    'label' => Yii::t('ssupport_core', 'Nickname'),
                    'value' => $ticket->getCustomer()->getNickname(),
                ],
                'assign' => [
                    'label' => Yii::t('ssupport_core', 'Assign'),
                    'value' => $ticket->getAssigns()[0]->getNickname(),
                ],
                'created_at' => 'created_at:datetime',
                'updated_at' => 'updated_at:datetime',
            ],
        ];
    }

    /** @var callable */
    public $urlCreateGrid = [self::class, 'urlCreatorDefault'];

    public static function urlCreatorDefault($action, $model, $key, $index, $actionColumn)
    {
        $params = \is_array($key) ? $key : ['ticketId' => (string) $key];
        $params[0] = $actionColumn->controller ? $actionColumn->controller.'/'.$action : $action;

        return Url::toRoute($params);
    }

    public $agentGridViewConfig = [self::class, 'getAgentGridViewConfigDefault'];

    public static function getAgentGridViewConfigDefault(AgentGridViewSettingsInterface $config)
    {
        return [
            'dataProvider' => $config->dataProvider(),
            'filterModel' => $config->searchModel(),
            'rowOptions' => \Closure::fromCallable([self::class, 'defaultRowOptions']),
            'columns' => [
                'id' => $config->id(),
                'subject' => $config->subject(),
                'customer' => $config->customer(),
                'updated_at' => $config->updatedAt(),
                'action_column' => $config->actionColumn(),
            ],
        ];
    }

    public $customerGridViewConfig = [self::class, 'getCustomerGridViewConfigDefault'];

    public static function getCustomerGridViewConfigDefault(CustomerGridViewSettingsInterface $config)
    {
        $a = 1;

        return [
            'dataProvider' => $config->dataProvider(),
            'filterModel' => $config->searchModel(),
            'rowOptions' => \Closure::fromCallable([self::class, 'defaultRowOptions']),
            'columns' => [
                'id' => $config->id(),
                'subject' => $config->subject(),
                'assign' => $config->assign(),
                'updated_at' => $config->updatedAt(),
                'action_column' => $config->actionColumn(),
            ],
        ];
    }

    public static function defaultRowOptions($ticket)
    {
        /** @var Ticket $ticket */
        $class = '';
        if (!$ticket->isReader(Yii::$app->getUser()->getIdentity())) {
            $class = 'info';
        }

        return [
            'class' => $class,
        ];
    }
}
