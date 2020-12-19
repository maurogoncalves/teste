<?php
Class Paciente_model extends CI_Model
{
 
 function listarPacientes($id){	
   if($id == 0){
	 $sql = "select codigo,nome_pac,nome_mae_pac,foto_pac,data_nasc_pac,cpf_pac,cns_pac,numero_pac,cep_pac,lograd_pac,bairro_pac,munici_pac,uf_pac from paciente ";
	$query = $this->db->query($sql, array());  
   }else{
	$sql = "select codigo,nome_pac,nome_mae_pac,foto_pac,data_nasc_pac,cpf_pac,cns_pac,numero_pac,cep_pac,lograd_pac,bairro_pac,munici_pac,uf_pac from paciente where codigo = ? ";
	$query = $this->db->query($sql, array($id));   
   }
    
    $array = $query->result(); 
    return($array);
 }
 
 
  
function atualizar($tabela,$dados,$id){
	$this->db->where('codigo', $id);
	$this->db->update($tabela, $dados); 
	
	return true;
 } 
 function add($detalhes = array()){
	if($this->db->insert('paciente', $detalhes)) {
		return $id = $this->db->insert_id();
	}	
}
 
 
 
 function excluir($id){
	$this->db->where('codigo', $id);
	$this->db->delete('paciente'); 
	return true;
 } 
	 
}
?>