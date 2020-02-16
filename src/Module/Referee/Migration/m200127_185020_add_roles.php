<?php

namespace SSupport\Module\Referee\Migration;

use SSupport\Module\Referee\Module;
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
    }

    public function safeDown()
    {
        $auth = $this->getAuthManager();

        $agent = $auth->getRole(Module::REFEREE_ROLE);
        $auth->remove($agent);
    }

    /**
     * @return ManagerInterface
     */
    public function getAuthManager()
    {
        return Yii::$app->authManager;
    }
}
