<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	
 function __construct(){
   parent::__construct();
   $this->load->model('Paciente_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
   $this->load->library('Cep');
  
 }
 
 public function index(){
	
	$dataHeader['usuario'] = 'OM30';
	
	$this->load->view('header_view',$dataHeader);	
	$this->load->view('admin_view');
	$this->load->view('footer_view');
 }
 

function subir(){		
	$codigo = $this->input->post('codigo');	
	if(isset($_FILES['file']['name'])){
	
	// file name
	$filename = $_FILES['file']['name'];

	$file = str_replace("'", "", $_FILES['file']['name']);
	$extensao = str_replace('.','',strrchr($file, '.'));		
	
	// Location
	$location = 'upload/'.$codigo.'.'.$extensao;

	// file extension
	$file_extension = pathinfo($location, PATHINFO_EXTENSION);
	$file_extension = strtolower($file_extension);

	// Valid image extensions
	$valid_ext = array("pdf","doc","docx","jpg","png","jpeg");

	$response = 0;
	if(in_array($file_extension,$valid_ext)){
	  	// Upload file
	  	if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	    	$response = 1;
			$dados = array(
				'foto_pac' => $codigo.'.'.$extensao,
			);							
			$this->Paciente_model->atualizar('paciente',$dados,$codigo);	
	  	}	
	}

	echo $response;
	exit;
	}
}
 
 
  public function listar(){
	$data['pacs'] = $this->Paciente_model->listarPacientes(0);
	$dataHeader['usuario'] = '';
	$this->load->view('header_view',$dataHeader);	
	$this->load->view('listar_dados_view',$data);
	$this->load->view('footer_view');
 }
 
  public function novo(){
	$dataHeader['usuario'] = $data = '';
	$this->load->view('header_view',$dataHeader);	
	$this->load->view('novo_view',$data);
	$this->load->view('footer_view');
 }
 
  public function editar(){
	$id = $this->input->post('id');	  
	$data['pac'] = $this->Paciente_model->listarPacientes($id);
	

	$dataHeader['usuario'] = '';
	$this->load->view('header_view',$dataHeader);	
	$this->load->view('editar_view',$data);
	$this->load->view('footer_view');
 }
 
  public function add(){

	if($_POST){
		$nomePac = $this->input->post('nomePac');	
		$nomeMaePac = $this->input->post('nomeMaePac');	
		$dataNasc = $this->input->post('dataNasc');	
		$cpfPac = $this->input->post('cpfPac');	
		$cnsPac = $this->input->post('cnsPac');	
		$cep = $this->input->post('cep');	
		$numero = $this->input->post('numero');	
		$logradouro = $this->input->post('logradouro');	
		$bairro = $this->input->post('bairro');	
		$cidade = $this->input->post('cidade');	
		$uf = $this->input->post('uf');	
		
		
		$dados = array('nome_pac' => $nomePac,
						'nome_mae_pac' => $nomeMaePac,
						'foto_pac' => '',
						'data_nasc_pac' => $dataNasc,
						'cpf_pac' => $cpfPac,
						'cns_pac' => $cnsPac,
						'cep_pac' => $cep,
						'numero_pac' => $numero,
						'lograd_pac' => $logradouro,
						'bairro_pac' => $bairro,
						'munici_pac' => $cidade,
						'uf_pac' => $uf,
		);
	
		if($this->Paciente_model->add($dados)){
			echo 1;
		}else{
			echo 0;
		}
		
	
	}else{
		
		echo 0;
	}
 }
 
 public function edit(){

	if($_POST){
		$nomePac = $this->input->post('nomePac');	
		$nomeMaePac = $this->input->post('nomeMaePac');	
		$dataNasc = $this->input->post('dataNasc');	
		$cpfPac = $this->input->post('cpfPac');	
		$cnsPac = $this->input->post('cnsPac');	
		$cep = $this->input->post('cep');	
		$numero = $this->input->post('numero');	
		$logradouro = $this->input->post('logradouro');	
		$bairro = $this->input->post('bairro');	
		$cidade = $this->input->post('cidade');	
		$uf = $this->input->post('uf');	
		$codigo = $this->input->post('codigo');	
		
		$dados = array('nome_pac' => $nomePac,
						'nome_mae_pac' => $nomeMaePac,
						'foto_pac' => '',
						'data_nasc_pac' => $dataNasc,
						'cpf_pac' => $cpfPac,
						'cns_pac' => $cnsPac,
						'cep_pac' => $cep,
						'numero_pac' => $numero,
						'lograd_pac' => $logradouro,
						'bairro_pac' => $bairro,
						'munici_pac' => $cidade,
						'uf_pac' => $uf,
		);
	
		if($this->Paciente_model->atualizar('paciente',$dados,$codigo)){
			echo 1;
		}else{
			echo 0;
		}
		
	
	}else{
		
		echo 0;
	}
 }
 
function buscaCep(){

	 $this->load->library('cep');
	 $cep = $this->input->get('cep');
	 $this->cep->busca_cep($cep);  

	}
function excluir()	{
		
		$codigo = $this->input->get('codigo');
		$this->Paciente_model->excluir($codigo);
		$obj['tem'] = 0; 		
		
		echo(json_encode($obj));
		
		
	}	

	
}
