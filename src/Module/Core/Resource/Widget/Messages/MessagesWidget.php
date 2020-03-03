<?php

namespace SSupport\Module\Core\Resource\Widget\Messages;

use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class MessagesWidget extends Widget
{
    /** @var ActiveDataProvider */
    public $dataProvider;

    public $currentUser;
    public $renderPath = '@SSupport/Module/Core/Resource/Widget/Messages/view/index';

    public function init()
    {
        parent::init();

        $this->currentUser = $this->currentUser ?? Yii::$app->getUser()->getIdentity();
    }

    public function run()
    {
        return $this->render(
            $this->renderPath,
            [
                'dataProvider' => $this->dataProvider,
                'currentUser' => $this->currentUser,
            ]
        );
    }
}
