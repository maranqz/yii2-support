<?php

namespace SSupport\Module\Referee\Resource\Widget\RequestReferee;

use SSupport\Module\Referee\Controller\customer\referee\IndexController;
use SSupport\Module\Referee\Gateway\Repository\TimeoutRequestReferee\GetTimeoutRequestRefereeInterface;
use SSupport\Module\Referee\Gateway\TimeoutRequestRefereeStatus\TimeoutRequestRefereeStatusInterface;
use SSupport\Module\Referee\Utils\RefereeModuleAwareTrait;
use Yii;
use yii\base\Widget;

class RequestRefereeCustomerWidget extends Widget
{
    use RefereeModuleAwareTrait;

    public $ticket;

    protected $timeoutRequestRefereeStatus;
    protected $getTimeoutRequestReferee;

    public function __construct(
        TimeoutRequestRefereeStatusInterface $timeoutRequestRefereeStatus,
        GetTimeoutRequestRefereeInterface $getTimeoutRequestReferee,
        $config = []
    ) {
        parent::__construct($config);
        $this->timeoutRequestRefereeStatus = $timeoutRequestRefereeStatus;
        $this->getTimeoutRequestReferee = $getTimeoutRequestReferee;
    }

    public function run()
    {
        $timeoutRequestRefereeStatus = $this->timeoutRequestRefereeStatus;
        $getTimeoutRequestReferee = $this->getTimeoutRequestReferee;
        $ticket = $this->ticket;

        if ($timeoutRequestRefereeStatus->hasReferee($ticket)) {
            return Yii::$app->formatter->asText($ticket->getReferee()->getNickname());
        }

        if ($timeoutRequestRefereeStatus->canRequestReferee($ticket)) {
            return RequestRefereeButtonWidget::widget([
                'ticketId' => $ticket->getId(),
                'hasRequested' => $ticket->hasReferee(),
                'options' => [
                    'class' => 'btn btn-danger',
                ],
            ]);
        }

        if ($timeoutRequestRefereeStatus->canSetTimeoutRequestReferee($ticket)) {
            return RequestRefereeButtonWidget::widget([
                'ticketId' => $ticket->getId(),
                'hasRequested' => $ticket->hasReferee(),
                'url' => [
                    '/' . $this->getRefereeModuleName() . '/' . IndexController::PATH . '/request',
                    'ticketId' => $ticket->getId(),
                ],
            ]);
        }

        return Yii::t('ssupport_referee', 'You can invite a referee in {time}.', [
            'time' => Yii::$app->formatter->asDuration(
                $getTimeoutRequestReferee($ticket)->getRemainingTimeoutRequest()
            ),
        ]);
    }

    protected function getRefereeModuleName()
    {
        return $this->getSupportRefereeModule()::$name;
    }
}
