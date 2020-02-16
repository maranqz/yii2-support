<?php

namespace SSupport\Module\Referee\Resource\Widget\RequestReferee;

use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Referee\Controller\customer\referee\IndexController;
use SSupport\Module\Referee\Module;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class RequestRefereeWidget extends Widget
{
    use ContainerAwareTrait;

    const DEFAULT_PATH = '/'.Module::DEFAULT_NAME.'/'.IndexController::PATH.'/request';

    public $text;
    public $url;
    public $options = [
        'class' => 'btn btn-warning',
    ];
    public $ticketId;

    public $hasRequested = false;

    public $formOptions = [
        'data' => [
            'method' => 'POST',
            'params' => [],
            'pjax' => false,
        ],
    ];

    public function init()
    {
        parent::init();

        if (empty($this->text)) {
            $this->text = Yii::t('ssupport', 'Request referee');
        }

        if (empty($this->url)) {
            $this->url = [static::DEFAULT_PATH, 'ticketId' => $this->ticketId];
        }
    }

    public function run()
    {
        if ($this->hasRequested) {
            return '';
        }

        /** @var Html $html */
        $html = $this->make(Html::class);

        return $html::a($this->text, $this->url, array_merge_recursive($this->options, $this->formOptions));
    }
}
