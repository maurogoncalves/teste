<script src="<?php echo $this->config->base_url(); ?>assets/adm/js/jquery-1.9.1.min.js"></script>

<script>
	$(document).ready(function(){
		$('#form').submit(function(event){		  
			if (form.checkValidity()) {			
				send.attr('disabled', 'disabled');		  
			}		
		});	
	});	
	
	// Upload file
	function uploadFile() {
		var codigo = $("#codigo").val();
		var files = document.getElementById("file").files;
		
		if(files.length > 0 ){ 

			var formData = new FormData();
			formData.append("file", files[0]);
			formData.append("codigo", codigo);

			var xhttp = new XMLHttpRequest();

			// Set POST method and ajax file path
			xhttp.open("POST", "<?php echo $this->config->base_url();?>index.php/Admin/subir", true);

			// call on request changes state
			xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			      	
			      	var response = this.responseText;
			      	if(response == 1){
			      		alert("Upload foi realizado.");

			      	}else{ 
			      		alert("Upload não foi realizado."); 
			      	}
			    }
			};
			
			// Send request with data
			xhttp.send(formData);

		}else{
			alert("Selecione um arquivo");
		}
		
	}
	
	 function buscaCep() {
	var cep = $("#cep").val();
	
	$.ajax({
		url: '<?php echo $this->config->base_url();?>index.php/Admin/buscaCep?cep='+cep,
		type: 'GET',
		dataType: 'json',  
		beforeSend: function () {
			//Aqui adicionas o loader
			$("#divCorpo").fadeIn('fast');
		},         		
		success: function(data) {
			$("#uf").val(data.uf);
			$("#logradouro").val(data.logradouro);
			$("#bairro").val(data.bairro);
			$("#cidade").val(data.cidade);
			$('#divCorpo').fadeOut('fast');
			console.log("sucesso");
		},	
		error: function() {
			console.log("erro");
		}   
	});
 
}

	$(document).on( 'click', "#enviar", function(evt){
		var msg ='';
		var nomePac = $("#nomePac").val();
		var nomeMaePac = $("#nomeMaePac").val();
		var dataNasc = $("#dataNasc").val();
		var cpfPac = $("#cpfPac").val();
		var cnsPac = $("#cnsPac").val();
		
		var cep = $("#cep").val();
		var numero = $("#numero").val();
		var logradouro = $("#logradouro").val();
		var bairro = $("#bairro").val();
		var cidade = $("#cidade").val();
		var uf = $("#uf").val();
		var codigo = $("#codigo").val();
		
		if (nomePac == ""){
			msg =msg+'Digite o nome do paciente \r\n';
		}
		if (nomeMaePac == ""){
			msg =msg+'Digite o nome da mãe paciente \r\n';
		}
		if (dataNasc == ""){
			msg =msg+'Digite a data de nascimento \r\n';
		}
		if (cpfPac == ""){
			msg =msg+'Digite o cpf \r\n';
		}
		if (cnsPac == ""){
			msg =msg+'Digite o cns \r\n';
		}
		
		var dataTestada = (validaData(dataNasc));
		if (dataTestada){					
		}else{
			msg =msg+'Data Inválida \r\n';
		}
		
		var cpfTestado = (TestaCPF(cpfPac));		
		if (cpfTestado){					
		}else{
			msg =msg+'CPF Inválido \r\n';
		}
		
		if( (cnsPac.substr(0, 1) == 1) || (cnsPac.substr(0, 1) == 2)){
			
			cnsLimpo = cnsPac.replace(" ", "");
			var cnsTestado = (cnsInicioUm(cnsLimpo));	
		}else{
			cnsLimpo = cnsPac.replace(" ", "");
			var cnsTestado = (cnsInicioOutro(cnsLimpo));	
			
		}
		
		if (cnsTestado){					
		}else{
			msg =msg+'CNS Inválido \r\n';
		}
		
		if (msg == ""){	
			$.ajax({
			 method: "POST",
			 url: '<?php echo $this->config->base_url();?>index.php/Admin/edit',
			 data: { codigo:codigo,nomePac:nomePac,nomeMaePac:nomeMaePac,dataNasc:dataNasc,cpfPac:cpfPac,cnsPac:cnsPac, cep:cep, numero:numero,logradouro:logradouro,bairro:bairro,cidade:cidade,uf:uf },
			 dataType: 'json',
			success: function(response) {

				if (response == 1) {
					alert("Paciente foi atualizado");	
					window.location.href = "<?php echo $this->config->base_url();?>index.php/Admin/listar";
				}else{
					alert("Erro, tente novamente mais tarde");
				}

				


			}
			});
		}else{
			alert(msg);
		}
		
	});		
	
	function TestaCPF(strCPF) {		
		//https://www.devmedia.com.br/validar-cpf-com-javascript/23916
		strCPF = ( strCPF.replace(/[^\d]+/g,'') );
		var Soma;
		var Resto;
		Soma = 0;
		 if (strCPF == "00000000000") return false;
		 for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
		 Resto = (Soma * 10) % 11;
		if ((Resto == 10) || (Resto == 11))  Resto = 0;
		if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
		Soma = 0;
		for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
		Resto = (Soma * 10) % 11;
		if ((Resto == 10) || (Resto == 11))  Resto = 0;
		if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
		return true;
	}
		
	function cnsInicioUm(cnsPac) {		
		if (cnsPac.length != 15){
		return(false);
		}

		var soma;
		var resto, dv;
		var pis ;
		var resultado ;
		pis = cnsPac.substring(0, 11);
		
		soma = cnsPac.substr(0, 1) * 15 + cnsPac.substr(1, 2) * 14 + cnsPac.substr(2, 3) * 13 + cnsPac.substr(3, 4) * 12 + cnsPac.substr(4, 5) * 11 + cnsPac.substr(5, 6) * 10 + cnsPac.substr(6, 7) * 9 + cnsPac.substr(7, 8) * 8 + cnsPac.substr(8, 9) * 7 +  cnsPac.substr(9, 10) * 6 +  cnsPac.substr(10, 11) * 5 ; 

		resto = soma % 11;
		dv = 11 - resto;

		if (dv == 11){
			dv = 0;
		}

		if (dv == 10){
			
		soma = (cnsPac.substr(0, 1) * 15 + cnsPac.substr(1, 2) * 14 + cnsPac.substr(2, 3) * 13 + cnsPac.substr(3, 4) * 12 + cnsPac.substr(4, 5) * 11 + cnsPac.substr(5, 6) * 10 + cnsPac.substr(6, 7) * 9 + cnsPac.substr(7, 8) * 8 + cnsPac.substr(8, 9) * 7 + cnsPac.substr(9, 10) * 6 + cnsPac.substr(10, 11) * 5) + 2 ; 
		
		resto = soma % 11;
		dv = 11 - resto;
		resultado = pis + "001" + dv;
		}
		else{
		resultado = pis + "000" + dv;
		}

		if (!cnsPac.equals(resultado)){
			return(false);
		}else{
			return(true);
		}
    }
	
	function cnsInicioOutro(cnsPac) {		
		if (cnsPac.length != 15){
			return(false);
		}

		var dv;
		var resto,soma;

		soma = cnsPac.substr(0, 1) * 15 + cnsPac.substr(1, 2) * 14 + cnsPac.substr(2, 3) * 13 + cnsPac.substr(3, 4) * 12 + cnsPac.substr(4, 5) * 11 + cnsPac.substr(5, 6) * 10 + cnsPac.substr(6, 7) * 9 + cnsPac.substr(7, 8) * 8 + cnsPac.substr(8, 9) * 7 + cnsPac.substr(9, 10) * 6 + cnsPac.substr(10, 11) * 5 + cnsPac.substr(11, 12) * 4 + cnsPac.substr(12, 13) * 3 + cnsPac.substr(13, 14) * 2 +  cnsPac.substr(14, 15) * 1; 
		
		
		resto = soma % 11;
		if (resto != 0){
			return(false);
		}
		else{
			return(true);
		}
	}
	
function validaData(date) {
	var ardt=new Array;
		var ExpReg=new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
		ardt=date.split("/");
		if ( date.search(ExpReg)==-1){
			return true;
		}else if (((ardt[1]==4)||(ardt[1]==6)||(ardt[1]==9)||(ardt[1]==11))&&(ardt[0]>30)){
			return true;
		}else if ( ardt[1]==2) {
			if ((ardt[0]>28)&&((ardt[2]%4)!=0))
				return true;
			if ((ardt[0]>29)&&((ardt[2]%4)==0))
				return true;
		}else{
			return false;
		}
		
}


</script>


<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<a href="<?php echo $this->config->base_url(); ?>index.php/Admin/listar"><span class="hidden-tablet">Voltar para Lista de Pacientes</span></a>					
					</div>
					<div class="box-content">
					<fieldset>
					 <legend>Novo Paciente</legend>
					 <div class="control-group">
						<?php 	
						$base = base_url();
						$filename = 'upload/'.$pac[0]->foto_pac;	
						if(file_exists($filename)) { 
						?>
							<img src="<?php echo$base.$filename?>" alt="<?php echo $pac[0]->nome_pac?>" width="100" height="100">
							
						<?php 	
						}
					  ?>
					 </div>
					  
					<div class="control-group">
						<label for="exampleInputEmail1">Upload Foto</label>
						
						<input type="file" name="file" id="file" placeholder="Escolher Arquivo">
						
						
						<input style='height:30px!important' class="btn btn-warning"  type="button" id="btn_uploadfile" value="Upload" onclick="uploadFile();">
		
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Nome Completo do Paciente (*)</label>
						<input type="text" class="form-control" style='width:500px' id="nomePac" value='<?php echo $pac[0]->nome_pac?>' name="nomePac" required placeholder="Nome Completo do Paciente">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Nome Completo da Mãe (*)</label>
						<input type="text" class="form-control" style='width:500px' id="nomeMaePac" value='<?php echo $pac[0]->nome_mae_pac?>' name="nomeMaePac" required placeholder="Nome Completo da Mãe">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Data de Nascimento (*)</label>
						<input type="text" class="form-control" id="dataNasc" name="dataNasc" value='<?php echo $pac[0]->data_nasc_pac?>' data-mask="99/99/9999" maxlength="10"required placeholder="Data Nascimento do Paciente">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">CPF (*)</label>
						<input type="text" class="form-control" id="cpfPac" name="cpfPac" value='<?php echo $pac[0]->cpf_pac?>'   maxlength="14" data-mask="999.999.999-99"  required placeholder="CPF do paciente">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Cartão Nacional do Sus (*) 898004601911313</label>
						<input type="text" class="form-control" id="cnsPac" name="cnsPac"  value='<?php echo $pac[0]->cns_pac?>' data-mask="999999999999999" maxlength="15" required placeholder="Cartão Nacional do Sus">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">CEP</label>
						<input type="text" class="form-control" id="cep" name="cep" data-mask="99.999-999" value='<?php echo $pac[0]->cep_pac?>' maxlength="10" onblur="buscaCep()"   placeholder="CEP">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Número</label>
						<input type="text" class="form-control" id="numero" name="numero"  maxlength="5" value='<?php echo $pac[0]->numero_pac?>'  placeholder="Número">
					  </div>
					  
					   <div class="control-group">
						<label for="exampleInputEmail1">Logradouro</label>
						<input type="text" class="form-control" style='width:500px' id="logradouro" name="logradouro"   value='<?php echo $pac[0]->lograd_pac?>' placeholder="Logradouro">
					  </div>
					  
					   <div class="control-group">
						<label for="exampleInputEmail1">Bairro</label>
						<input type="text" class="form-control" style='width:500px' id="bairro" name="bairro"  value='<?php echo $pac[0]->bairro_pac?>'  placeholder="Bairro">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Cidade</label>
						<input type="text" class="form-control" style='width:500px' id="cidade" name="cidade"  value='<?php echo $pac[0]->munici_pac?>'  placeholder="Cidade">
					  </div>
					  
					   <div class="control-group">
						<label for="exampleInputEmail1">UF</label>
						<input type="text" class="form-control" id="uf" name="uf" value='<?php echo $pac[0]->uf_pac?>'   placeholder="UF">
						<input type="hidden" class="form-control" id="codigo" name="codigo" value='<?php echo $pac[0]->codigo?>' >
					  </div>
					  
					  <p class="btn btn-primary" id='enviar'>Enviar</p>

							
						  </fieldset>
						           
					</div>
				</div><!--/span-->
			
			</div><!--/row-->	
		

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
		