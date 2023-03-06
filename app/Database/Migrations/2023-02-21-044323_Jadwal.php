<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jadwal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'jadwal_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_jam' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'id_lapangan' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'harga' => [
                'type' => 'INT',
                'constraint' => '10',
            ],
            'status_booking' => [
                'type' => 'INT',
                'constraint' => '2',
            ],
        ]);
        $this->forge->addKey('jadwal_id', true);
        $this->forge->createTable('jadwals');
    }

    public function down()
    {
        $this->forge->dropTable('jadwals');
    }
}
