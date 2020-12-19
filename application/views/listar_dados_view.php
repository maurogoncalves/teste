<script src="<?php echo $this->config->base_url(); ?>assets/adm/js/jquery-1.9.1.min.js"></script>
<script>
	$(document).ready(function(){
		
		$('.excluir').click(function(){	
			var answer = confirm("Deseja excluir esse item?");
			if (answer){
				var id = $(this).attr('id');
				 $.ajax({
					url: "<?php echo $this->config->base_url(); ?>index.php/Admin/excluir?codigo=" + id,
					type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 
					contentType: "application/json; charset=utf-8",
					dataType: 'json', /* Tipo de transmiss&atilde;o */
					success: function(data){
						alert('Foi excluído com sucesso.');
						$('#linha-'+id).remove();								
					}
				});				
			}	
			
		});	
	});	
</script>


<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon list-alt"></i><span class="break"><b>Lista de Pacientes</b></span>
						&nbsp;&nbsp;&nbsp;
						<a href="<?php echo $this->config->base_url(); ?>index.php/Admin/novo"><i class="icon-plus"></i><span class="hidden-tablet"><b>Novo Paciente</b></span></a>
						
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" id="forj">
						  <thead>
							  <tr>
								 
								 <th>Nome Paciente</th>	
								 <th>Data Nascimento Paciente</th>	
								 <th>Nome Mãe Paciente</th>	
								 <th>CPF Paciente</th>	
								 <th>CNS Paciente</th>	
								 <th>Ações</th>								  
							 </tr>
						  </thead>   
						  <tbody>
							<?php 
								$isArray =  is_array($pacs) ? '1' : '0';
								if($isArray == 0){ ?>
								<?php 
								}else{
								 foreach($pacs as $key => $pac){ 
								 ?>
								 <tr id='linha-<?php echo $pac->codigo?>'>
								 <td ><?php echo $pac->nome_pac; ?> </td>
								 <td ><?php echo $pac->data_nasc_pac; ?> </td>
								 <td ><?php echo $pac->nome_mae_pac; ?> </td>
								 <td ><?php echo $pac->cpf_pac; ?> </td>
								 <td ><?php echo $pac->cns_pac; ?> </td>
								 <td >
								 <a  href="<?php echo $this->config->base_url(); ?>index.php/Admin/editar?id=<?php echo $pac->codigo;?>"><i class="halflings-icon pencil" style='height:20px'  title='Editar' alt='Editar'></i></a>
								 &nbsp;
								 <i class="halflings-icon remove excluir" style='height:20px' id='<?php echo $pac->codigo;?>'  title='Apagar' alt='Apagar'></i>
								 </td>
								</tr>
								<?php
								}//fim foreach
								}//fim if
								?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->	
		

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		