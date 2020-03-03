<?php

namespace SSupport\Module\Core\Migration;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 * Has foreign keys to the tables:.
 *
 * - `{{%ticket}}`
 * - `{{%user}}`
 */
class m191207_143556_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'ticket_id' => $this->integer()->notNull(),
            'sender_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `ticket_id`
        $this->createIndex(
            '{{%idx-message-ticket_id}}',
            '{{%message}}',
            'ticket_id'
        );

        // add foreign key for table `{{%ticket}}`
        $this->addForeignKey(
            '{{%fk-message-ticket_id}}',
            '{{%message}}',
            'ticket_id',
            '{{%ticket}}',
            'id',
            'CASCADE'
        );

        // creates index for column `sender_id`
        $this->createIndex(
            '{{%idx-message-sender_id}}',
            '{{%message}}',
            'sender_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-message-sender_id}}',
            '{{%message}}',
            'sender_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%ticket}}`
        $this->dropForeignKey(
            '{{%fk-message-ticket_id}}',
            '{{%message}}'
        );

        // drops index for column `ticket_id`
        $this->dropIndex(
            '{{%idx-message-ticket_id}}',
            '{{%message}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-message-sender_id}}',
            '{{%message}}'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            '{{%idx-message-sender_id}}',
            '{{%message}}'
        );

        $this->dropTable('{{%message}}');
    }
}
