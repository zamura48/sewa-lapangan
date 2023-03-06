<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lapangan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'lapangan_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nomor' => [
                'type' => 'INT',
                'constraint' => '5',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => '2',
            ],
        ]);
        $this->forge->addKey('lapangan_id', true);
        $this->forge->createTable('lapangans');
    }

    public function down()
    {
        $this->forge->dropTable('lapangans');
    }
}
