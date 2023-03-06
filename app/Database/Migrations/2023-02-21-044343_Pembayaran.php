<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pembayaran_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
            ],
            'id_booking' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'status_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => "'CASH', 'DP'",
            ],
            'no_rek' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
        ]);
        $this->forge->addKey('pembayaran_id', true);
        $this->forge->createTable('pembayarans');
    }

    public function down()
    {
        $this->forge->dropTable('pembayarans');
    }
}
