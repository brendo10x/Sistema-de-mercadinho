
<div id="main-content"> 
  <!--início #main-content-->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <h3 class="page-title"><?php echo $titulo ?> </h3>
        <ul class="breadcrumb">
          <li><a href="<?php echo $this -> Html -> url('/'); ?>"><i
							class="icon-home"></i></a><span class="divider">&nbsp;</span></li>
          <li><a href="#"><?php echo $titulo ?> </a><span
						class="divider-last">&nbsp;</span></li>
        </ul>
      </div>
    </div>
    <?php

        if ($this->Session->check('sucesso')) {
            
    ?>
    <div class="alert alert-success">
      <button class="close" data-dismiss="alert">x</button>
      <strong><?php echo __('Sucesso') ?>!</strong> <?php echo $this->Session->read('sucesso') ?>. </div>
    <?php } ?>
    <form id="formDados"
			action="<?php echo $this -> Html -> url(array("controller" => "vendas", "action" => "novo")); ?>"
			method="post">
      <div class="row-fluid">
        <div class="span12">
          <div class="widget">
            <div class="widget-title">
              <h4> <i class="icon-reorder"></i><?php echo __('Informações sobre venda') ?></h4>
              <span class="tools"><a href="javascript:;"
								class="icon-chevron-down"></a></span> </div>
            <div class="widget-body form">
              <div class="form-horizontal">
                <div class="control-group">
                  <label class="control-label"><?php echo __('Escolha cliente') ?>: </label>
                  <div class="controls ">
                    <input type="text" id="cliente" autocomplete="off" name="nomeCliente" class="required span8" />
                    <input type="hidden" id="idCliente" name="data[Venda][cliente_id]" />
                  </div>
                </div>
                
                 <!--Autocomplete cliente-->    
                <?php echo $this -> element('scriptAutocompleteCliente'); ?>
                
                <!-- Produtos vendidos -->
                <input type="hidden" name="data[ProdutoVendido][quantidade]" value="">
                <input type="hidden" name="data[ProdutoVendido][produto_id]" value="">
                <input type="hidden" name="data[ProdutoVendido][venda_id]" value="">
                
                <div class="control-group">
                  <label class="control-label"><?php echo __('Data') ?>: </label>
                  <div class="controls ">
                    <input type="text" class="span2 data_datepicker" required="required"  name="data[Venda][data]" />
                  </div>
                </div>
                
                <input type="hidden" value="1" name="data[Venda][vendedor_id]" />
                
                <div class="control-group">
                  <label class="control-label"><?php echo __('Forma de pagamento') ?>:</label>
                  <div class="controls">
                    <select id="sel_forma_pagamento" name="data[Venda][ven_forma_pagamento]" class="span2">
                      <option value="0"><?php echo __('Á vista') ?></option>
                      <option value="1"><?php echo __('Prazo') ?></option>
                    </select>
                  </div>
                </div>
                
                <!-- adiciona, remove campos, autocomplete de produtos e cálculo dos produtos --> 
                <?php echo $this -> element('scriptAutocompleteProdutoEcalcVenda'); ?>
                
                <div id="InputsWrapper"> 
                  
                  <!-- chamada para o autocomplete de produto -->
                  <div class="control-group">
                    <label class="control-label"><?php echo __('Escolha produto') ?> :</label>
                    <div class="controls">
                      <input id="produto" type="text" class="span5" />
                      <span id="AddMoreFileBox"></span> </div>
                    <!-- fim .controls --> 
                  </div>
                  <!-- fim .control-group -->
                  
                  <div class="control-group">
                    <label class="control-label"><?php echo __('Total venda') ?>: </label>
                    <div class="controls "> <b style="color: #51A351; font-size: 40px"><span
												id="grandTotal">R$0.00</span></br>
                    </div>
                  </div>
                </div>
                <!-- fim #InputsWrapper -->
                <div class="form-actions">
                  <button  type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
                </div>
                
                <!-- total venda -->
                <input type="hidden" name="data[Venda][ven_total]" id="totalVenda" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="prazoDiv" class="row-fluid">
        <div class="span12">
          <div class="widget">
            <div class="widget-title">
              <h4> <i class="icon-reorder"></i><?php echo __('Prazo') ?></h4>
              <span class="tools"><a href="javascript:;"
								class="icon-chevron-down"></a></span> </div>
            <div class="widget-body form">
              <div class="form-horizontal">
                <div class="control-group">
                  <label class="control-label"><?php echo __('Número de parcelas') ?>:</label>
                  <div class="controls">
                    <select id="gerarParcelas" name="data[Parcela][numero]"
											class="span2">
                      <option value="0"><?php echo __('Escolha') ?></option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="data[Parcela][data]" class="span2" />
                <div class="control-group">
                  <label class="control-label"><?php echo __('Parcelas') ?>: </label>
                  <div class="controls "> <span id="nParcelas"></span> <span id="vParcelas"></span> </div>
                </div>
                <input type="hidden" name="data[Parcela][valor]"
									id="valorParcelaHide" />
                <input type="hidden"
									name="data[Parcela][venda_id]" />
                <input type="hidden"
									name="data[Parcela][pago]" />
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
<!-- importe do plugin validator --> 
<?php echo $this -> Html -> script('jquery.validate'); ?> 
<?php echo $this -> Html -> script('jquery.validate.msg-' . $usuario['Config']['idioma']); ?>
<script type="text/javascript">
    //inicialmente se esconde
    // o conteiner do prazo
    $('#prazoDiv').hide();

    $("#sel_forma_pagamento").change(function() {

        if ($("#sel_forma_pagamento").val() == 0) {

            $('#prazoDiv').hide();

        } else {

            $('#prazoDiv').show();
        }

    });
</script> 
<script type="text/javascript">

                //inicializa

$( "#gerarParcelas" ).change(function() {

    if($( "#gerarParcelas" ).val() !=0){ 
        $('#nParcelas').html($( "#gerarParcelas" ).val()+" <?php echo __('vezes de') ?>
            ");
            var total = $('#totalVenda').val()/$( "#gerarParcelas" ).val();
            //arredonda
            total = total.toFixed(2);
            $('#vParcelas').html("R$"+total);
            $('#valorParcelaHide').attr('value', total);
            }

            });

            // tutorial explicando http://tiagobutzke.wordpress.com/2010/11/17/plugin-validate-do-jquery-com-ajax-e-php/
            // outro http://jqueryvalidation.org/

            //adiciona novos métodos de validação

            //formulário
            $("#formDados").validate({

            //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>
            });

</script>

