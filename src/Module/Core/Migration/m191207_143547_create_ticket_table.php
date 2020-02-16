<?php

namespace SSupport\Module\Core\Migration;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticket}}`.
 * Has foreign keys to the tables:.
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m191207_143547_create_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ticket}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(1024)->notNull(),
            'customer_id' => $this->integer(),
            'assign_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `customer_id`
        $this->createIndex(
            '{{%idx-ticket-customer_id}}',
            '{{%ticket}}',
            'customer_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-ticket-customer_id}}',
            '{{%ticket}}',
            'customer_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `assign_id`
        $this->createIndex(
            '{{%idx-ticket-assign_id}}',
            '{{%ticket}}',
            'assign_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-ticket-assign_id}}',
            '{{%ticket}}',
            'assign_id',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-ticket-customer_id}}',
            '{{%ticket}}'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            '{{%idx-ticket-customer_id}}',
            '{{%ticket}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-ticket-assign_id}}',
            '{{%ticket}}'
        );

        // drops index for column `assign_id`
        $this->dropIndex(
            '{{%idx-ticket-assign_id}}',
            '{{%ticket}}'
        );

        $this->dropTable('{{%ticket}}');
    }
}
