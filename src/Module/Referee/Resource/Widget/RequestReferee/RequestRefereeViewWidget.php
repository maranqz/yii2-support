<?php

namespace SSupport\Module\Referee\Resource\Widget\RequestReferee;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Module\Referee\Gateway\Repository\TimeoutRequestReferee\GetTimeoutRequestRefereeInterface;
use SSupport\Module\Referee\Gateway\TimeoutRequestRefereeStatus\TimeoutRequestRefereeStatusInterface;
use SSupport\Module\Referee\Utils\RefereeModuleAwareTrait;
use Yii;
use yii\base\Widget;

class RequestRefereeViewWidget extends Widget
{
    use RefereeModuleAwareTrait;

    /** @var RefereeTicketInterface */
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
        $ticket = $this->ticket;
        $timeoutRequestRefereeStatus = $this->timeoutRequestRefereeStatus;
        $timeoutRequestReferee = ($this->getTimeoutRequestReferee)($ticket);

        if ($timeoutRequestRefereeStatus->hasReferee($ticket)) {
            return Yii::$app->formatter->asText($ticket->getReferee()->getNickname());
        }

        if ($timeoutRequestReferee->alreadyTimeoutRequest()) {
            return Yii::t('ssupport_referee', 'Customer can invite a referee in {time}.', [
                'time' => Yii::$app->formatter->asDuration(
                    $timeoutRequestReferee->getRemainingTimeoutRequest()
                ),
            ]);
        }

        return null;
    }
}
