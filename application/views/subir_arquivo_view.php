<script src="<?php echo $this->config->base_url(); ?>assets/adm/js/jquery-1.9.1.min.js"></script>
<script>
	$(document).ready(function(){
		$('#form').submit(function(event){		  
			if (form.checkValidity()) {			
				send.attr('disabled', 'disabled');		  
			}		
		});				
	
	});	
function mascara_data(data){ 
              var mydata = ''; 
              mydata = mydata + data; 
              if (mydata.length == 2){ 
                  mydata = mydata + '/'; 
                  document.forms[0].data.value = mydata; 
              } 
              if (mydata.length == 5){ 
                  mydata = mydata + '/'; 
                  document.forms[0].data.value = mydata; 
              } 
              if (mydata.length == 10){ 
                  verifica_data(); 
              } 
          } 
           
          function verifica_data () { 
 
            dia = (document.forms[0].data.value.substring(0,2)); 
            mes = (document.forms[0].data.value.substring(3,5)); 
            ano = (document.forms[0].data.value.substring(6,10)); 
 
            situacao = ""; 
            // verifica o dia valido para cada mes 
            if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31) { 
                situacao = "falsa"; 
            } 
 
            // verifica se o mes e valido 
            if (mes < 01 || mes > 12 ) { 
                situacao = "falsa"; 
            } 
 
            // verifica se e ano bissexto 
            if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
                situacao = "falsa"; 
            } 
    
            if (document.forms[0].data.value == "") { 
                situacao = "falsa"; 
            } 
    
            if (situacao == "falsa") { 
                alert("Data inválida!"); 
                document.forms[0].data.focus(); 
            } 
          } 
</script>

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<span class="hidden-tablet">Subir arquivo para  : <?php echo $transparencia[0]->descricao?> </span>
					</div>
					<div class="box-content">
					<form class="form-horizontal" action="<?php echo $this->config->base_url(); ?>index.php/Admin/upload"" method="post"  enctype="multipart/form-data" >
						  <fieldset>
													  
							<div class="control-group">
							  <label class="control-label" for="fileInput">(*) Observação do item</label>
							  <div class="controls">
							  <textarea id="observacao" name="observacao" readonly='yes' style='height:100px;width:90%' > <?php echo $transparencia[0]->observacao?>       </textarea>
							  </div>
							</div>

							
							<div class="control-group">
							  <label class="control-label" for="fileInput">  Mês/Ano de Referência <?php echo $transparencia[0]->ano_referencia?></label>
							  <div class="controls">
								<input type="text" class="form-control" readonly='yes' name="data" maxlength="10" id="anoReferencia"  value='<?php echo $transparencia[0]->ano_referencia?>'>
								
							  </div>
							</div>
							
							
							<div class="control-group">
							  <label class="control-label" for="fileInput">Tipo de Item</label>
							  <div class="controls">
								<select class="form-control" disabled name='item' style='width:400px'>  
								  <option value="0">Escolha o item</option>	
									<?php foreach($itens as $key => $item){ ?>
									<?php if($item->id == $transparencia[0]->tipo){ ?>
										<option value="<?php echo $item->id ?>" selected><?php echo $item->descricao?></option>	
									<?php }else{ ?>	
										<option value="<?php echo $item->id ?>" ><?php echo $item->descricao?></option>	
									<?php	}								  							 
									}
									?>			
								</select>
								
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="fileInput">Fazer upload do arquivo</label>
							  <div class="controls">
								<input type="file" name="userfile">
								
							  </div>
							</div>
							
							<div class="form-actions">
								<input type="hidden" id="idItem"  name="idItem"  value='<?php echo $transparencia[0]->id?>'>
								<input type="hidden" id="tipoItem"  name="tipoItem"  value='<?php echo $transparencia[0]->tipo?>'>
							  <button type="submit" class="btn btn-primary" >Alterar</button>
							  <button type="reset" class="btn">Cancelar</button>
							  
							</div>
						  </fieldset>
						</form>   
						           
					</div>
				</div><!--/span-->
			
			</div><!--/row-->	
		

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
		