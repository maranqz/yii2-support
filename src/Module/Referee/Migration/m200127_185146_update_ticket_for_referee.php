<?php

namespace SSupport\Module\Referee\Migration;

use yii\db\Migration;

class m200127_185146_update_ticket_for_referee extends Migration
{
    const INDEX_TICKET_REFEREE_ID = 'idx-ticket-referee_id';
    const FOREIGN_KEY_TICKET_REFEREE_ID = 'fk-ticket-referee_id';

    const TABLE_TICKET = '{{%ticket}}';
    const FIELD_REFEREE_ID = 'referee_id';

    public function safeUp()
    {
        $this->addColumn(self::TABLE_TICKET, self::FIELD_REFEREE_ID, $this->integer()->null()->after('assign_id'));

        $this->createIndex(self::INDEX_TICKET_REFEREE_ID, self::TABLE_TICKET, self::FIELD_REFEREE_ID);

        $this->addForeignKey(
            self::FOREIGN_KEY_TICKET_REFEREE_ID,
            self::TABLE_TICKET,
            self::FIELD_REFEREE_ID,
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            self::FOREIGN_KEY_TICKET_REFEREE_ID,
            self::TABLE_TICKET
        );

        $this->dropIndex(self::INDEX_TICKET_REFEREE_ID, self::TABLE_TICKET);

        $this->dropColumn(self::TABLE_TICKET, self::FIELD_REFEREE_ID);
    }
}
