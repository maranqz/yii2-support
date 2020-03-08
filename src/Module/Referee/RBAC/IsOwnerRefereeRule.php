<?php

namespace SSupport\Module\Referee\RBAC;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Module\Referee\Module;
use Yii;
use yii\rbac\Rule;

class IsOwnerRefereeRule extends Rule
{
    const NAME = 'IsOwnerRefereeRule';

    public $name = self::NAME;

    public function execute($refereeId, $item, $params)
    {
        return $this->hasTicket($params) && $this->isRefereeRole($refereeId)
            && $this->isTicketBelongReferee($refereeId, $params['ticket']);
    }

    protected function isRefereeRole($refereeId)
    {
        return Yii::$app->authManager->checkAccess($refereeId, Module::REFEREE_ROLE);
    }

    protected function hasTicket($params)
    {
        return isset($params['ticket']);
    }

    /**
     * @param TicketInterface|RefereeTicketInterface $ticket
     */
    protected function isTicketBelongReferee($refereeId, TicketInterface $ticket = null)
    {
        return !empty($ticket->getReferee()) && $refereeId === $ticket->getReferee()->getId();
    }
}
