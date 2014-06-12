 
<div id="main-content"> 
	<!--início #main-content-->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<h3 class="page-title"><?php echo $titulo ?> </h3>
				<ul class="breadcrumb">
					<li> <a href="<?php echo $this->Html->url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
					<li> <a href="#"><?php echo $titulo ?> </a><span class="divider-last">&nbsp;</span> </li>
				</ul>
			</div>
		</div>
		<?php

		if ($this->Session->check('sucesso')) { ?>

		<div class="alert alert-success">
			<button class="close" data-dismiss="alert"> x </button>
			<strong><?php echo __('Sucesso') ?>!</strong> <?php echo $this->Session->read('sucesso') ?>. </div>

			<?php } ?>

			<form id="formDados" action="<?php echo $this->Html->url(array("controller" => "configsBoletos", "action" => "configuracaoBoleto")); ?>"   method="post">

				<div class="row-fluid">
					<div class="span12">
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-reorder"></i><?php echo __('Informações básicas sobre boleto') ?></h4>
								<span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
								<div class="widget-body form">

									<div style="display:none" class="alert alert-error">
										<button class="close" data-dismiss="alert"> × </button>
										<strong><?php echo __('Atenção') ?>!</strong> 
										<span id="infoAlerta"></span>.
									</div>

									<div class="form-horizontal">

										<div class="control-group">
											<label class="control-label"><?php echo __('Taxa de boleto') ?>: </label>
											<div class="controls ">
												<input type="text" required="required" value="<?php echo $configBoleto['ConfigBoleto']['taxa_boleto']['valor'] ?>" name="data[0][ConfigBoleto][valor]" class="span2"  />
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['taxa_boleto']['id'] ?>" name="data[0][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Espécie') ?>: </label>
											<div class="controls ">
												<input type="text" required="required" value="<?php echo $configBoleto['ConfigBoleto']['especie']['valor'] ?>" name="data[1][ConfigBoleto][valor]" class="span2"  />
												
												<input type="hidden" required="required" value="<?php echo $configBoleto['ConfigBoleto']['especie']['id'] ?>" name="data[1][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Início nosso número') ?>: </label>
											<div class="controls ">
												<input type="text" required="required" value="<?php echo $configBoleto['ConfigBoleto']['inicio_nosso_numero']['valor'] ?>" name="data[2][ConfigBoleto][valor]" class="span2"  />
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['inicio_nosso_numero']['id'] ?>" name="data[2][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Nosso número') ?>: </label>
											<div class="controls ">
												<input type="text" required="required" value="<?php echo $configBoleto['ConfigBoleto']['nosso_numero']['valor'] ?>" name="data[3][ConfigBoleto][valor]" class="span2"  />
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['nosso_numero']['id'] ?>" name="data[3][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Demonstrativo') ?>: </label>
											<div class="controls">
												<textarea name="data[4][ConfigBoleto][valor]" required="required"  class="span6 " rows="3"><?php echo $configBoleto['ConfigBoleto']['demonstrativo']['valor'] ?></textarea>
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['demonstrativo']['id'] ?>" name="data[4][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Instruções') ?>: </label>
											<div class="controls">
												<textarea required="required" name="data[5][ConfigBoleto][valor]"  class="span6 " rows="3"><?php echo $configBoleto['ConfigBoleto']['instrucoes']['valor'] ?></textarea>
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['instrucoes']['id'] ?>" name="data[5][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Agência') ?>: </label>
											<div class="controls ">
												<input type="text" required="required" value="<?php echo $configBoleto['ConfigBoleto']['agencia']['valor'] ?>" name="data[6][ConfigBoleto][valor]" class="span2"  />
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['agencia']['id'] ?>" name="data[6][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Conta') ?>: </label>
											<div class="controls ">
												<input type="text" required="required" value="<?php echo $configBoleto['ConfigBoleto']['conta']['valor'] ?>" name="data[7][ConfigBoleto][valor]" class="span2"  />
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['conta']['id'] ?>" name="data[7][ConfigBoleto][id]"    />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label"><?php echo __('Dígito da Conta') ?>: </label>
											<div class="controls ">
												<input type="text" required="required" value="<?php echo $configBoleto['ConfigBoleto']['conta_dv']['valor'] ?>" name="data[8][ConfigBoleto][valor]" class="span2"  />
												
												<input type="hidden"  value="<?php echo $configBoleto['ConfigBoleto']['conta_dv']['id'] ?>" name="data[8][ConfigBoleto][id]"  />
											</div>
										</div>
										<div class="form-actions">
											<button   type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
										</div>

									</div>

								</div>
							</div>

						</div>
					</div>


					
				</form>
				<!--fim formulário--> 

			</div>
		</div>
		<!--fim #main-content--> 

		<?php echo $this -> Html -> script('jquery.validate'); ?>
		<?php echo $this->Html->script('jquery.validate.msg-'.$usuario['Config']['idioma']); ?>

		<script type="text/javascript">


     //formulário
     $("#formDados").validate({

        //validator opções
        <?php echo $this->element('validatorOpcoes'); ?>

});

 </script>

