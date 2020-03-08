<?php

namespace SSupport\Module\Referee\Migration;

use SSupport\Module\Referee\Module;
use SSupport\Module\Referee\RBAC\IsOwnerRefereeRule;
use Yii;
use yii\db\Migration;
use yii\rbac\ManagerInterface;

class m200127_185020_add_roles extends Migration
{
    public function safeUp()
    {
        $auth = $this->getAuthManager();

        $agent = $auth->createRole(Module::REFEREE_ROLE);
        $auth->add($agent);

        $isOwnerRefereeRule = new IsOwnerRefereeRule();
        $auth->add($isOwnerRefereeRule);

        $isOwnerRefereePermission = $auth->createPermission(IsOwnerRefereeRule::NAME);
        $isOwnerRefereePermission->ruleName = $isOwnerRefereeRule->name;
        $auth->add($isOwnerRefereePermission);
        $auth->addChild($agent, $isOwnerRefereePermission);
    }

    public function safeDown()
    {
        $auth = $this->getAuthManager();

        $agent = $auth->getRole(Module::REFEREE_ROLE);
        $auth->remove($agent);

        $isOwnerRefereeRule = $auth->getRule(IsOwnerRefereeRule::NAME);
        $auth->remove($isOwnerRefereeRule);

        $isOwnerRefereePermission = $auth->getPermission(IsOwnerRefereeRule::NAME);
        $auth->remove($isOwnerRefereePermission);
    }

    /**
     * @return ManagerInterface
     */
    public function getAuthManager()
    {
        return Yii::$app->authManager;
    }
}
