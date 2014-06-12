 
<div id="main-content"> 
  <!--início #main-content-->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <h3 class="page-title"><?php echo $titulo ?> </h3>
        <ul class="breadcrumb">
          <li> <a href="<?php echo $this -> Html -> url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
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

      <div class="row-fluid">
        <div class="span12">
          <div class="widget">
            <div class="widget-title">
              <h4><i class="icon-reorder"></i><?php echo __('Consultas total venda') ?></h4>
              <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
              <div class="widget-body form">
                <div class="form-horizontal">
                  <div class="row-fluid">
                    <div class="span12">
                      <div class="tabbable tabbable-custom tabs-left">
                        <ul class="nav nav-tabs tabs-left">
                          <li  class="active" > <a href="#tab_3_1" data-toggle="tab"><?php echo __('Total das vendas no mês ou dia')  ?></a> </li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active " id="tab_3_1">
                            <form  id="formDados" action="<?php echo $this -> Html -> url(array("controller" => "financeiros", "action" => "index")); ?>" method="post">
                               <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">
                                <input required="required"  placeholder="<?php echo __('Data') ?>..."  class="span2 data_datepicker" name="data[data]" value="<?php (!empty($data)) ? print $data : null; ?>"  type="text"  />
                               
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- span principal -->
                    </div>
                    <div class="control-group">
                      <label class="control-label"><?php echo __('Total vendas') ?>: </label>
                      <div class="controls "> <span style="color:green;font-size:20px">R$<?php (!empty($totalVendasPesquisado)) ? print $totalVendasPesquisado : print '00.00'; ?></span> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <form id="formDados2" action="<?php echo $this -> Html -> url(array("controller" => "financeiros", "action" => "index")); ?>"   method="post">
            <div class="row-fluid">
              <div class="span12">
                <div class="widget">
                  <div class="widget-title">
                    <h4><i class="icon-reorder"></i><?php echo __('Saque ou depósito finânceiro') ?></h4>
                    <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
                    <div class="widget-body form">
                      <div class="form-horizontal">

                        <?php if (!empty($financeiro['Financeiro']['valor_total'])) {?>
                            
                        <div class="control-group">
                          <label class="control-label"><?php echo __('Total em caixa') ?>: </label>
                          <div class="controls "> <span style="color:green;font-size:20px">R$<?php echo $financeiro['Financeiro']['valor_total'] ?></span> </div>
                          <input type="hidden" id="totalCaixa"  value="<?php echo  $financeiro['Financeiro']['valor_total'] ?>" />
                          <input type="hidden" name="data[Financeiro][id]"   value="<?php echo $financeiro['Financeiro']['id'] ?>" />
                          <input type="hidden" id="totalVendas" name="data[Financeiro][valor_total]"   />
                        </div>

                        <div class="control-group">
                          <label class="control-label"><?php echo __('Valor') ?>: </label>
                          <div class="controls ">
                            <input required="required" type="text" id="valorEscolhido"  class="number span3" />
                          </div>
                        </div>
                        <div class="control-group">
                          <label class="control-label"><?php echo __('Operação') ?>:</label>
                          <div class="controls">
                            <select  id="tipoOperacao" class="span3" >

                              <option value="1" ><?php echo __('Depositar') ?></option>
                              <option value="2" ><?php echo __('Retirar') ?></option>
                            </select>
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label"><?php echo __('Perspectiva valor') ?>: </label>
                          <div class="controls "> <span id="perspectivaValor" style="color:green;font-size:20px">R$00.00</span> </div>
                        </div>

                        <div class="form-actions">
                         <button   type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
                       </div>
                         <?php  }else{ ?>
                                <h1> <?php echo __('Desenvolvedor informe algum valor inicial no financeiro')  ?>! </h1>
                         <?php  } ?>
                       
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
      <?php echo $this -> Html -> script('jquery.validate.msg-'. $usuario['Config']['idioma']); ?>

       <script type="text/javascript">
        //formulário
        $("#formDados").validate({

              //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>
        
        });

        //formulário
        $("#formDados2").validate({

              //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>
        
        });

        $("#tipoOperacao").change(function() {

            //id= perspectivaValor
            //id= valorEscolhido
            //totalVendas
            var tipo = $("#tipoOperacao").val()

            if ($("#valorEscolhido").val() != "") {
                if (tipo == 1) {
                    //subtrair
                    var total = parseFloat($('#totalCaixa').val()) + parseFloat($("#valorEscolhido").val());
                    total = total.toFixed(2);
                    $('#perspectivaValor').html("R$" + total);
                    $('#totalVendas').attr('value', total);
                };

                if (tipo == 2) {
                    //subtrair
                    var total = parseFloat($('#totalCaixa').val()) - parseFloat($("#valorEscolhido").val());
                    total = total.toFixed(2);
                    $('#perspectivaValor').html("R$" + total);
                    $('#totalVendas').attr('value', total);
                };

            };

        });

        $("#valorEscolhido").change(function() {

            //id= perspectivaValor
            //id= valorEscolhido
            //totalVendas
            var tipo = $("#tipoOperacao").val();
            if ($("#valorEscolhido").val() != "") {
                if (tipo == 1) {
                    //subtrair
                    var total = parseFloat($('#totalCaixa').val()) + parseFloat($("#valorEscolhido").val());
                    total = total.toFixed(2);
                    $('#perspectivaValor').html("R$" + total);
                    $('#totalVendas').attr('value', total);
                };

                if (tipo == 2) {
                    //subtrair
                    var total = parseFloat($('#totalCaixa').val()) - parseFloat($("#valorEscolhido").val());
                    total = total.toFixed(2);
                    $('#perspectivaValor').html("R$" + total);
                    $('#totalVendas').attr('value', total);

                };

            };

        });

 </script> 