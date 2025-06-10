<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMahasiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'angkatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 4,
                'null'       => false,
            ],
            'prodi_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'kelas_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nim');
        $this->forge->addForeignKey('user_id', 'tbl_user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('prodi_id', 'tbl_prodi', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('kelas_id', 'tbl_kelas', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('tbl_mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_mahasiswa');
    }
}
