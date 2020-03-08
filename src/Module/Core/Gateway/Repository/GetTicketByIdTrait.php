<?php

namespace SSupport\Module\Core\Gateway\Repository;

use SSupport\Component\Core\Entity\TicketInterface;

trait GetTicketByIdTrait
{
    protected $tickets = [];

    protected function getTicketByIdOrNull($ticketId)
    {
        if (empty($ticketId)) {
            return null;
        }

        if (empty($this->tickets[$ticketId])) {
            $this->tickets[$ticketId] = $this->make(TicketInterface::class)::findOne($ticketId);
        }

        return $this->tickets[$ticketId];
    }

    protected function getTicketById($id)
    {
        /** @var TicketInterface $model */
        if (null !== ($model = $this->getTicketByIdOrNull($id))) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}
