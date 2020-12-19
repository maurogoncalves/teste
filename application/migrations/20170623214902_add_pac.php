<?php
class Migration_Add_pac extends CI_Migration
{
    public function up()
    {

        $this->dbforge->add_field(
           array(
              'codigo' => array(
                 'type' => 'INT',
                 'constraint' => 11,
                 'unsigned' => true,
                 'auto_increment' => true
              ),
              'nome_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '300',
              ),
              'nome_mae_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '300',
              ),
			  'foto_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '20',
              ),
			  'data_nasc_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '11',
              ),
			   'cpf_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '20',
              ),
			   'cns_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '20',
              ),			  
			  'numero_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '5',
              ),
			  'cep_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '10',
              ),
			   'lograd_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '300',
              ),
			   'bairro_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '300',
              ),
			   'munici_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '300',
              ),
			   'uf_pac' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '2',
              ),
           )
        );

        $this->dbforge->add_key('codigo', TRUE);
        $this->dbforge->create_table('paciente');
    }

    public function down()
    {
        $this->dbforge->drop_table('paciente');
    }
}