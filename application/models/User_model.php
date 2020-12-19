<?php
Class User_model extends CI_Model
{
 function login($nome_usuario, $password){
   $this -> db -> select('administracao.id, administracao.usuario');
   $this -> db -> from('administracao');
   $this -> db -> where('administracao.usuario', $nome_usuario);
   $this -> db -> where('administracao.senha', $password);
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() == 1){
     return $query->result();
   } else {
     return false;
   }
 }
 

 
 function listarUsuarios(){	
    $sql = "select u.nome_usuario,u.email,s.nome_setor,u.telefone,u.id,u.status from usuarios u left join setor s on s.id = u.id_setor";
	$query = $this->db->query($sql, array());
    $array = $query->result(); 
    return($array);
 }
 
 
  
 function atualizar($senha,$id){
 	$dados = array('senha' => $senha);
	$this->db->where('id', $id);
	$this->db->update('usuarios', $dados); 
	//print_r($this->db->last_query());exit;
	return true; 
 }
 
 function add($detalhes = array()){
	if($this->db->insert('usuarios', $detalhes)) {
		return $id = $this->db->insert_id();
	}	
}
 
 
   function atualizar_dados_usuario($dados,$id){
 	$this->db->where('id', $id);
	$this->db->update('usuarios', $dados); 
	//print_r($this->db->last_query());exit;
	return true;
 }
 function excluir($id){
	$this->db->where('id', $id);
	$this->db->delete('usuarios'); 
	return true;
 } 
	 
}
?>