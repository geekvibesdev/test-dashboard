<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgenteReportesLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pregunta' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'sql_generado' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'resultado_resumido' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'respuesta_nl' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'error' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'fecha_creado' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('fecha_creado');
        $this->forge->createTable('agente_reportes_log');
    }

    public function down()
    {
        $this->forge->dropTable('agente_reportes_log');
    }
}
