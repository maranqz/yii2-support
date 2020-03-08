<?php

namespace SSupport\Module\Referee;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessage as AgentAfterSendMessage;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessage as CustomerAfterSendMessage;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\AfterRequestReferee;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\AfterSendMessage as RefereeAfterSendMessage;
use SSupport\Module\Core\Module as CoreModule;
use SSupport\Module\Core\Utils\ModuleTrait;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettingsInterface;
use SSupport\Module\Referee\Resource\Widget\RequestReferee\RequestRefereeCustomerWidget;
use SSupport\Module\Referee\Resource\Widget\RequestReferee\RequestRefereeViewWidget;
use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    use ModuleTrait;

    const DEFAULT_NAME = 'support-referee';
    const REFEREE_ROLE = 'support-referee';

    public static $name = self::DEFAULT_NAME;

    public $prefix;

    /**
     * delay before customer can request referee.
     *
     * @var int|bool
     */
    public $timeoutRequestReferee = false;

    public $routes = [
        '<path:(customer/referee)>/<controller>/<action>' => '<path>/<controller>/<action>',
        '<path:(referee[\w\/]*)>/<controller>/<action>' => '<path>/<controller>/<action>',
    ];

    public $controllerNamespace = 'SSupport\Module\Referee\Controller';

    public $uploaderListenerEvents = [
        RefereeAfterSendMessage::class,
    ];

    public $listeners = [];

    public $defaultListeners = [
        RefereeAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromReferee'],
        AgentAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromAgent'],
        CustomerAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromCustomer'],
        AfterRequestReferee::class => [NotifierListenerInterface::class, 'customerRequestRefereeForReferee'],
    ];

    public $refereeGridViewConfig = [self::class, 'getRefereeGridViewConfigDefault'];

    public function getRefereeGridViewConfig(RefereeGridViewSettingsInterface $config): iterable
    {
        return ($this->refereeGridViewConfig)($config);
    }

    public static function getRefereeGridViewConfigDefault(RefereeGridViewSettingsInterface $config)
    {
        return [
            'dataProvider' => $config->dataProvider(),
            'filterModel' => $config->searchModel(),
            'rowOptions' => \Closure::fromCallable([CoreModule::class, 'defaultRowOptions']),
            'columns' => [
                'id' => $config->id(),
                'subject' => $config->subject(),
                'assign' => $config->assign(),
                'customer' => $config->customer(),
                'updated_at' => $config->updatedAt(),
                'action_column' => $config->actionColumn(),
            ],
        ];
    }

    public $refereeViewDetailConfig = [CoreModule::class, 'getRefereeViewDetailConfigDefault'];

    public function getRefereeViewDetailConfig(TicketInterface $ticket): iterable
    {
        return ($this->refereeViewDetailConfig)($ticket);
    }

    public static function getRefereeViewDetailConfigDefault(RefereeTicketInterface $ticket)
    {
        $core = CoreModule::getViewDetailConfigDefault($ticket);
        $refereeAttributes = static::getRefereeViewDetailConfigAttributes($ticket);

        $core['attributes'] = CoreModule::appendArrayInPlace(
            $core['attributes'] + $refereeAttributes,
            [
                'nickname',
                'assign',
                'referee',
                'created_at',
                'updated_at',
            ]
        );

        return $core;
    }

    public static function getRefereeViewDetailConfigAttributes(RefereeTicketInterface $ticket)
    {
        $label = Yii::t('ssupport_referee', 'Referee');

        return [
            'referee' => [
                'label' => $label,
                'value' => function ($model) {
                    return RequestRefereeViewWidget::widget([
                        'ticket' => $model,
                    ]) ?: null;
                },
            ],
            'referee_customer' => [
                'label' => $label,
                'value' => function ($model) {
                    return RequestRefereeCustomerWidget::widget([
                        'ticket' => $model,
                    ]) ?: null;
                },
                'format' => 'html',
            ],
        ];
    }
}
