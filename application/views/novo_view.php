<script src="<?php echo $this->config->base_url(); ?>assets/adm/js/jquery-1.9.1.min.js"></script>
<script>
	$(document).ready(function(){
		$('#form').submit(function(event){		  
			if (form.checkValidity()) {			
				send.attr('disabled', 'disabled');		  
			}		
		});				
	});	
	
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
			 url: '<?php echo $this->config->base_url();?>index.php/Admin/add',
			 data: { nomePac:nomePac,nomeMaePac:nomeMaePac,dataNasc:dataNasc,cpfPac:cpfPac,cnsPac:cnsPac, cep:cep, numero:numero,logradouro:logradouro,bairro:bairro,cidade:cidade,uf:uf },
			 dataType: 'json',
			success: function(response) {

				if (response == 1) {
					alert("Paciente foi cadastrado");	
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
						<label for="exampleInputEmail1">Nome Completo do Paciente (*)</label>
						<input type="text" class="form-control" style='width:500px' id="nomePac" name="nomePac" required placeholder="Nome Completo do Paciente">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Nome Completo da Mãe (*)</label>
						<input type="text" class="form-control" style='width:500px' id="nomeMaePac" name="nomeMaePac" required placeholder="Nome Completo da Mãe">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Data de Nascimento (*)</label>
						<input type="date" class="form-control" id="dataNasc" name="dataNasc"   maxlength="10"required placeholder="Data Nascimento do Paciente">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">CPF (*)</label>
						<input type="text" class="form-control" id="cpfPac" name="cpfPac"  maxlength="14" data-mask="999.999.999-99"  required placeholder="CPF do paciente">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Cartão Nacional do Sus (*) 898004601911313</label>
						<input type="text" class="form-control" id="cnsPac" name="cnsPac"  data-mask="999999999999999" maxlength="15" required placeholder="Cartão Nacional do Sus">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">CEP</label>
						<input type="text" class="form-control" id="cep" name="cep" data-mask="99.999-999"  maxlength="10" onblur="buscaCep()"   placeholder="CEP">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Número</label>
						<input type="text" class="form-control" id="numero" name="numero"  maxlength="5"  placeholder="Número">
					  </div>
					  
					   <div class="control-group">
						<label for="exampleInputEmail1">Logradouro</label>
						<input type="text" class="form-control" style='width:500px' id="logradouro" name="logradouro"    placeholder="Logradouro">
					  </div>
					  
					   <div class="control-group">
						<label for="exampleInputEmail1">Bairro</label>
						<input type="text" class="form-control" style='width:500px' id="bairro" name="bairro"    placeholder="Bairro">
					  </div>
					  
					  <div class="control-group">
						<label for="exampleInputEmail1">Cidade</label>
						<input type="text" class="form-control" style='width:500px' id="cidade" name="cidade"    placeholder="Cidade">
					  </div>
					  
					   <div class="control-group">
						<label for="exampleInputEmail1">UF</label>
						<input type="text" class="form-control" id="uf" name="uf"    placeholder="UF">
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
		
		