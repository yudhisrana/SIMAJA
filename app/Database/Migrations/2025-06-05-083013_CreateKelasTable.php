<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
            ],
            'kelas_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false
            ],
            'semester_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false
            ],
            'tahun_ajaran_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('semester_id', 'tbl_semester', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('tahun_ajaran_id', 'tbl_tahun_ajaran', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('tbl_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_kelas');
    }
}
