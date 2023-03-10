<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jam extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'jam_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jam' => [
                'type' => 'TIME',
            ],
        ]);
        $this->forge->addKey('jam_id', true);
        $this->forge->createTable('jams');
    }

    public function down()
    {
        $this->forge->dropTable('jams');
    }
}
