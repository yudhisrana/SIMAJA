<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahunAjaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_tahun_ajaran');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_tahun_ajaran');
    }
}
