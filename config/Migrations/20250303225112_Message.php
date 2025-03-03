<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Message extends BaseMigration
{
    
    public function change(): void {
        $table = $this->table('messages');
        $table->addColumn('msg', 'string', [
            'null' => false,
            'limit' => 255,
        ]);
        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);
        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
        ]);
        $table->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'CASCADE',
        ]);
        $table->create();
    }
}
