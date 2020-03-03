<?php

namespace SSupport\Module\Core\UseCase\Customer\Repository;

use SSupport\Component\Core\Entity\CustomerInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInputInterface;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\UseCase\Customer\CreateTicketForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\web\ForbiddenHttpException;

class GetCustomerByCreteTicketInput implements GetCustomerByCreteTicketInputInterface
{
    use ContainerAwareTrait;

    /**
     * @param CreateTicketInputInterface|CreateTicketForm $input
     *
     * @throws \Throwable
     */
    public function __invoke(CreateTicketInputInterface $input): CustomerInterface
    {
        $user = Yii::$app->getUser();

        if ($user->isGuest) {
            /** @var CustomerInterface $user */
            $user = $this->make(CustomerInterface::class)::findOne([
                'nick_name' => $input->nick_name,
            ]);

            if (!Yii::$app->getAuthManager()->checkAccess($user->getId(), Module::CUSTOMER_ROLE)) {
                throw new ForbiddenHttpException();
            }

            return $user;
        }

        return $user->getIdentity();
    }
}
