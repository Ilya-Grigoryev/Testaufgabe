<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_projects_table extends CI_Migration
{
    public function up(): void
    {
        $this->load->dbforge();

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
            ],
            'budget' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => '0.00',
            ],
            'status' => [
                'type' => "ENUM('active','on_hold','archived')",
                'default' => 'active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => FALSE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('name');

        $this->dbforge->create_table('projects', TRUE, ['ENGINE' => 'InnoDB', 'DEFAULT CHARSET' => 'utf8mb4']);

        $this->seedInitialData();
    }

    public function down(): void
    {
        $this->dbforge->drop_table('projects', TRUE);
    }

    private function seedInitialData(): void
    {
        $now = date('Y-m-d H:i:s');

        $seed = [
            [
                'name' => 'Intranet Relaunch',
                'budget' => 15000,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => null,
            ],
            [
                'name' => 'Mobile App Prototype',
                'budget' => 5400,
                'status' => 'on_hold',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Legacy Data Migration',
                'budget' => 8200,
                'status' => 'archived',
                'created_at' => date('Y-m-d H:i:s', strtotime('-45 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-30 days')),
            ],
        ];

        $this->db->insert_batch('projects', $seed);
    }
}
