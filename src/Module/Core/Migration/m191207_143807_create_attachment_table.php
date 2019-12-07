<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attachment}}`.
 * Has foreign keys to the tables:.
 *
 * - `{{%message}}`
 */
class m191207_143807_create_attachment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'message_id' => $this->integer()->notNull(),
            'path' => $this->text()->notNull(),
            'size' => $this->integer()->notNull(),
            'driver' => $this->string()->notNull(),
        ]);

        // creates index for column `message_id`
        $this->createIndex(
            '{{%idx-attachment-message_id}}',
            '{{%attachment}}',
            'message_id'
        );

        // add foreign key for table `{{%message}}`
        $this->addForeignKey(
            '{{%fk-attachment-message_id}}',
            '{{%attachment}}',
            'message_id',
            '{{%message}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%message}}`
        $this->dropForeignKey(
            '{{%fk-attachment-message_id}}',
            '{{%attachment}}'
        );

        // drops index for column `message_id`
        $this->dropIndex(
            '{{%idx-attachment-message_id}}',
            '{{%attachment}}'
        );

        $this->dropTable('{{%attachment}}');
    }
}
