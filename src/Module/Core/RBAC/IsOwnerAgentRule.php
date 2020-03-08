<?php

namespace SSupport\Module\Core\RBAC;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Module;
use Yii;
use yii\rbac\Rule;

class IsOwnerAgentRule extends Rule
{
    const NAME = 'IsOwnerAgent';

    public $name = self::NAME;

    public function execute($agentId, $item, $params)
    {
        return $this->hasTicket($params) && $this->isAgentRole($agentId)
            && $this->isTicketBelongAgent($agentId, $params['ticket']);
    }

    protected function isAgentRole($agentId)
    {
        return Yii::$app->authManager->checkAccess($agentId, Module::AGENT_ROLE);
    }

    protected function hasTicket($params)
    {
        return isset($params['ticket']);
    }

    protected function isTicketBelongAgent($agentId, TicketInterface $ticket = null)
    {
        return \in_array($agentId, array_map(function ($assign) {
            return $assign->getId();
        }, $ticket->getAssigns()));
    }
}
