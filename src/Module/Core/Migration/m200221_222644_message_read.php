<?php

namespace SSupport\Module\Core\Migration;

use yii\db\Migration;

class m200221_222644_message_read extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%ticket}}', 'readers', $this->text()->after('assign_id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ticket}}', 'readers');
    }
}
