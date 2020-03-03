<?php

namespace SSupport\Module\Core\Migration;

use SSupport\Module\Core\Module;
use SSupport\Module\Core\RBAC\IsOwnerCustomerRule;
use Yii;
use yii\db\Migration;
use yii\rbac\ManagerInterface;

class m200119_222644_add_roles extends Migration
{
    public function safeUp()
    {
        $auth = $this->getAuthManager();

        $agent = $auth->createRole(Module::AGENT_ROLE);
        $auth->add($agent);

        $customer = $auth->createRole(Module::CUSTOMER_ROLE);
        $auth->add($customer);

        $isNotOwnerCustomerRule = new IsOwnerCustomerRule();
        $auth->add($isNotOwnerCustomerRule);

        $isNotOwnerCustomerPermission = $auth->createPermission(IsOwnerCustomerRule::NAME);
        $isNotOwnerCustomerPermission->ruleName = $isNotOwnerCustomerRule->name;
        $auth->add($isNotOwnerCustomerPermission);
        $auth->addChild($customer, $isNotOwnerCustomerPermission);
    }

    public function safeDown()
    {
        $auth = $this->getAuthManager();

        $agent = $auth->getRole(Module::AGENT_ROLE);
        $auth->remove($agent);

        $customer = $auth->getRole(Module::CUSTOMER_ROLE);
        $auth->remove($customer);

        $isNotOwnerCustomerRule = $auth->getRule(IsOwnerCustomerRule::NAME);
        $auth->remove($isNotOwnerCustomerRule);

        $isNotOwnerCustomerPermission = $auth->getPermission(IsOwnerCustomerRule::NAME);
        $auth->remove($isNotOwnerCustomerPermission);
    }

    /**
     * @return ManagerInterface
     */
    public function getAuthManager()
    {
        return Yii::$app->authManager;
    }
}
