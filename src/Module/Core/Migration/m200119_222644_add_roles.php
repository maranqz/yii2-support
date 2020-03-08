<?php

namespace SSupport\Module\Core\Migration;

use SSupport\Module\Core\Module;
use SSupport\Module\Core\RBAC\IsOwnerAgentRule;
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

        $isOwnerAgentRule = new IsOwnerAgentRule();
        $auth->add($isOwnerAgentRule);

        $isOwnerAgentPermission = $auth->createPermission(IsOwnerAgentRule::NAME);
        $isOwnerAgentPermission->ruleName = $isOwnerAgentRule->name;
        $auth->add($isOwnerAgentPermission);
        $auth->addChild($agent, $isOwnerAgentPermission);

        $customer = $auth->createRole(Module::CUSTOMER_ROLE);
        $auth->add($customer);

        $isOwnerCustomerRule = new IsOwnerCustomerRule();
        $auth->add($isOwnerCustomerRule);

        $isOwnerCustomerPermission = $auth->createPermission(IsOwnerCustomerRule::NAME);
        $isOwnerCustomerPermission->ruleName = $isOwnerCustomerRule->name;
        $auth->add($isOwnerCustomerPermission);
        $auth->addChild($customer, $isOwnerCustomerPermission);
    }

    public function safeDown()
    {
        $auth = $this->getAuthManager();

        $agent = $auth->getRole(Module::AGENT_ROLE);
        $auth->remove($agent);

        $isOwnerAgentRule = $auth->getRule(IsOwnerAgentRule::NAME);
        $auth->remove($isOwnerAgentRule);

        $isOwnerAgentPermission = $auth->getPermission(IsOwnerAgentRule::NAME);
        $auth->remove($isOwnerAgentPermission);

        $customer = $auth->getRole(Module::CUSTOMER_ROLE);
        $auth->remove($customer);

        $isOwnerCustomerRule = $auth->getRule(IsOwnerCustomerRule::NAME);
        $auth->remove($isOwnerCustomerRule);

        $isOwnerCustomerPermission = $auth->getPermission(IsOwnerCustomerRule::NAME);
        $auth->remove($isOwnerCustomerPermission);
    }

    /**
     * @return ManagerInterface
     */
    public function getAuthManager()
    {
        return Yii::$app->authManager;
    }
}
