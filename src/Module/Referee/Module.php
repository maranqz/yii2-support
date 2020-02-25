<?php

namespace SSupport\Module\Referee;

use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessage as AgentAfterSendMessage;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessage as CustomerAfterSendMessage;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\AfterRequestReferee;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\AfterSendMessage as RefereeAfterSendMessage;
use SSupport\Module\Core\Module as CoreModule;
use SSupport\Module\Core\Utils\ModuleTrait;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettingsInterface;
use SSupport\Module\Referee\Resource\Widget\RequestReferee\RequestRefereeWidget;
use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    use ModuleTrait;

    const DEFAULT_NAME = 'support-referee';
    const REFEREE_ROLE = 'support-referee';

    public static $name = self::DEFAULT_NAME;

    public $prefix;

    public $routes = [
        '<path:(customer)>/<controller:(referee)>/<action>' => '<path>/<controller>/<action>',
        '<path:(referee)>/<controller>/<action>' => '<path>/<controller>/<action>',
    ];

    public $controllerNamespace = 'SSupport\Module\Referee\Controller';

    public $uploaderListenerEvents = [
        RefereeAfterSendMessage::class,
    ];

    public $listeners = [
        RefereeAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromReferee'],
        AgentAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromAgent'],
        CustomerAfterSendMessage::class => [NotifierListenerInterface::class, 'sendMessageFromCustomer'],
        AfterRequestReferee::class => [NotifierListenerInterface::class, 'customerRequestRefereeForReferee'],
    ];

    public static function getViewDetailConfigDefault(RefereeTicketInterface $ticket)
    {
        return [
            'attributes' => [
                'referee' => [
                    'label' => Yii::t('ssupport_referee', 'Referee'),
                    'value' => function ($ticket) {
                        /** @var RefereeTicketInterface $ticket */
                        if ($ticket->getReferee()) {
                            return Yii::$app->formatter->asText($ticket->getReferee()->getNickname());
                        }

                        return RequestRefereeWidget::widget([
                            'ticketId' => $ticket->getId(),
                            'hasRequested' => $ticket->hasReferee(),
                        ]);
                    },
                    'format' => 'html',
                ],
            ],
        ];
    }

    public $refereeGridViewConfig = [self::class, 'getRefereeGridViewConfigDefault'];

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
}
