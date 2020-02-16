<?php

namespace SSupport\Module\Referee;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\AfterSendMessage;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettingsInterface;
use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
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
        AfterSendMessage::class,
    ];

    public static function getViewDetailConfigDefault(RefereeTicketInterface $ticket)
    {
        $refereeName = null;

        if ($ticket->getReferee()) {
            $refereeName = $ticket->getReferee()->getNickname();
        }

        return [
            'attributes' => [
                'referee' => [
                    'label' => Yii::t('ssupport', 'Referee'),
                    'value' => $refereeName,
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
            'columns' => [
                'id' => $config->id(),
                'subject' => $config->subject(),
                'assign' => $config->assign(),
                'customer' => $config->customer(),
                'created_at' => $config->createdAt(),
                'action_column' => $config->actionColumn(),
            ],
        ];
    }
}
