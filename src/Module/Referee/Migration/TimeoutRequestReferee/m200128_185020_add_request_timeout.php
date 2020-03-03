<?php

namespace SSupport\Module\Referee\Migration\TimeoutRequestReferee;

use yii\db\Migration;

class m200128_185020_add_request_timeout extends Migration
{
    const FIELD_REFEREE_REQUEST_TIMEOUT = 'referee_timeout';

    public function safeUp()
    {
        $this->addColumn('{{%ticket}}', self::FIELD_REFEREE_REQUEST_TIMEOUT, $this->integer()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%ticket}}', self::FIELD_REFEREE_REQUEST_TIMEOUT);
    }
}
