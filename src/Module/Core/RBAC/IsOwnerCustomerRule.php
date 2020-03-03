<?php

namespace SSupport\Module\Core\RBAC;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Module;
use Yii;
use yii\rbac\Rule;

class IsOwnerCustomerRule extends Rule
{
    const NAME = 'IsOwnerCustomer';

    public $name = self::NAME;

    public function execute($customerId, $item, $params)
    {
        return $this->hasTicket($params) && $this->isCustomerRole($customerId)
            && $this->isTicketBelongCustomer($customerId, $params['ticket']);
    }

    protected function isCustomerRole($customerId)
    {
        return Yii::$app->authManager->checkAccess($customerId, Module::CUSTOMER_ROLE);
    }

    protected function hasTicket($params)
    {
        return isset($params['ticket']);
    }

    protected function isTicketBelongCustomer($customerId, TicketInterface $ticket = null)
    {
        return $ticket->getCustomer()->getId() === $customerId;
    }
}
