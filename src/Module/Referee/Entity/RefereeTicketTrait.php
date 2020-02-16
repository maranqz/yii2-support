<?php

namespace SSupport\Module\Referee\Entity;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Module\Core\Exception\NotImplementedException;
use yii\db\ActiveRecordInterface;

trait RefereeTicketTrait
{
    public function getReferee(): ?RefereeInterface
    {
        return $this->__get('relateReferee');
    }

    /**
     * @param RefereeInterface|ActiveRecordInterface $user
     * @param UserInterface                          $requester
     *
     * @return $this
     */
    public function assignReferee(RefereeInterface $user, UserInterface $requester = null)
    {
        $this->link('relateReferee', $user);

        return $this;
    }

    public function deAssignReferee(RefereeInterface $user)
    {
        throw new NotImplementedException();
    }

    public function getRelateReferee()
    {
        return $this->hasOne($this->getDIClass(RefereeInterface::class), ['id' => 'referee_id']);
    }

    public function hasReferee(): bool
    {
        return (bool) ($this->__get('relateReferee'));
    }
}
