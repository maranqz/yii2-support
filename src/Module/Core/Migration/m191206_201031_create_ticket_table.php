<?php

use yii\db\Migration;

class m191206_201031_create_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ticket}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(1024)->notNull(),
            'assign_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ticket}}');
    }
}
