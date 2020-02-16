<?php

namespace SSupport\Module\Referee\Gateway\Repository;

use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\Gateway\Repository\GetRefereeForTicketInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Referee\Module;
use Yii;

class SimpleGetRefereeForTicket implements GetRefereeForTicketInterface
{
    use ContainerAwareTrait;

    public function __invoke(RefereeTicketInterface $ticket): RefereeInterface
    {
        $id = Yii::$app->getAuthManager()->getUserIdsByRole(Module::REFEREE_ROLE)[0];

        return $this->make(RefereeInterface::class)->findOne($id);
    }
}
