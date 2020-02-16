<?php

namespace SSupport\Module\Core;

use kartik\daterange\DateRangePicker;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessage as AgentAfterSendMessage;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\AfterCreateTicket;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessage as CustomerAfterSendMessage;
use SSupport\Module\Core\Resource\Assets\CommonAsset\CommonAsset;
use SSupport\Module\Core\Resource\config\GridView\AgentGridViewSettingsInterface;
use SSupport\Module\Core\Resource\config\GridView\CustomerGridViewSettingsInterface;
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
                    'label' => Yii::t('ssupport', 'Nickname'),
                    'value' => $ticket->getCustomer()->getNickname(),
                ],
                'assign' => [
                    'label' => Yii::t('ssupport', 'Assign'),
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
            'columns' => [
                'id' => $config->id(),
                'subject' => $config->subject(),
                'customer' => $config->customer(),
                'created_at' => $config->createdAt(),
                'action_column' => $config->actionColumn(),
            ],
        ];
    }

    public $customerGridViewConfig = [self::class, 'getCustomerGridViewConfigDefault'];

    public static function getCustomerGridViewConfigDefault(CustomerGridViewSettingsInterface $config)
    {
        return [
            'dataProvider' => $config->dataProvider(),
            'filterModel' => $config->searchModel(),
            'columns' => [
                'id' => $config->id(),
                'subject' => $config->subject(),
                'assign' => $config->assign(),
                'created_at' => $config->createdAt(),
                'action_column' => $config->actionColumn(),
            ],
        ];
    }

    public function init()
    {
        parent::init();

        CommonAsset::register(Yii::$app->view);
    }

    public static function gridId()
    {
        return [
            'attribute' => 'id',
            'headerOptions' => [
                'class' => 'cell_id',
            ],
            'filterOptions' => [
                'class' => 'cell_id',
            ],
            'contentOptions' => [
                'class' => 'cell_id',
            ],
        ];
    }

    public static function gridSubject()
    {
        return [
            'attribute' => 'subject',
            'headerOptions' => [
                'class' => 'text-truncate cell_subject',
            ],
            'filterOptions' => [
                'class' => 'text-truncate cell_subject',
            ],
            'contentOptions' => [
                'class' => 'text-truncate cell_subject',
            ],
        ];
    }

    public static function gridAssign()
    {
        return [
            'headerOptions' => [
                'class' => 'cell_assign',
            ],
            'label' => Yii::t('ssupport', 'Assign'),
            'value' => 'assigns.0.nickname',
        ];
    }

    public static function gridCustomer()
    {
        return [
            'headerOptions' => [
                'class' => 'cell_customer',
            ],
            'label' => Yii::t('ssupport', 'Customer'),
            'value' => 'customer.nickname',
        ];
    }

    public static function gridCreatedAt($searchModel)
    {
        return [
            'headerOptions' => [
                'class' => 'cell_created_at',
            ],
            'filter' => DateRangePicker::widget([
                'model' => $searchModel,
                'attribute' => 'createAtRange',
                'convertFormat' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd.m.Y H:i', //DD.MM.YYYY
                    ],
                    'timePicker' => true,
                    'timePicker24Hour' => true,
                    'timePickerIncrement' => 15,
                ],
            ]),
            'attribute' => 'created_at',
            'format' => 'datetime',
        ];
    }
}
