
<div id="main-content" > 
    <!--início #main-content-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title"><?php echo $titulo ?></h3>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo $this->Html->url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
                    <li>
                          <a href="<?php echo $this -> Html -> url(array('controller' => 'vendas', 'action' => 'listar')); ?>"><?php echo $breadcrumb_titulo ?></a><span class="divider">&nbsp;</span>
                      </li>
                    <li> <a href="#"><?php echo $titulo ?></a><span class="divider-last">&nbsp;</span> </li>
                </ul>
            </div>
        </div>

        <?php if($this -> Session -> check('sucesso')){ ?>

        <div  class="alert alert-success">
            <button class="close" > x </button>
            <strong><?php echo __('Sucesso') ?>!</strong> <?php echo $this -> Session -> read('sucesso'); ?>. 
        </div>

         <?php } ?>

        <?php  if ($this -> Session -> check('erro')) {?>

            <div class="alert alert-error">
                <button class="close" data-dismiss="alert"> x </button>
                <strong><?php echo __('Erro') ?>!</strong> <?php echo $this -> Session -> read('erro') ?>.

            </div>

        <?php } ?>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i><?php echo __('Tabela de dados') ?></h4>
                        <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
                    <div class="widget-body">
                        <div class="dataTables_wrapper form-inline" role="grid">

                            <div class="row-fluid">
                                <div class="span6">
                                    <form id="formDados"  action="<?php echo $this->Html->url(array("controller" => "Parcelas", "action" => "listar", "buscar")); ?>" method="post">
                                         <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">
                                        <input autocomplete="off" required="required" class="span3 datepicker" placeholder="<?php echo __('Pesquisa aqui') ?>..." type="text" name="data[buscar]" value="<?php (!empty($busca)) ? print $busca  : null; ?>"  >
                                       
                                        <input type="hidden" name="data[idVenda]" value="<?php  (!empty($parcela[0]['Venda']['id'])) ? print $parcela[0]['Venda']['id'] : null ;  ?>">
                                    </form>
                                </div>
                            </div>

                        

                            <form id="pagar_selecionados"  action="<?php echo $this->Html->url(array("controller" => "parcelas", "action" => "pagar_selecionados")); ?>" method="post">
                                <table class="table table-striped table-bordered dataTable" >
                                    <span style="display:none" id="carregandoInfo" ><img src="<?php echo $this->Html->url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 1%;"> 

                                                <input id="check" class="css-checkbox" type="checkbox" />
                                                <label for="check" class="css-label"></label>

                                            </th>
                                            <th style="width: 5%;"><?php echo __('Operações') ?></th>
                                            <?php $label = __('Pagamento'); ?>
                                            <th class="sorting" role="columnheader" style="width: 30%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this->Paginator->sort('Parcela.data', $label); ?>
                                                    <?php
                                                } else {

                                                          echo $label;
                                                     ?>

                                                <?php } ?>
                                            </th>
                                            <?php $label = __('Valor'); ?>
                                            <th class="hidden-phone sorting" style="width: 35%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this->Paginator->sort('Parcela.Venda.ven_forma_pagamento', $label); ?>
                                                    <?php
                                                } else {
                                                          echo $label;
                                                    ?>

                                                <?php } ?>
                                            </th>
                                            <?php $label = __('Pago'); ?>
                                            <th class="hidden-phone sorting" style="width: 30%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this->Paginator->sort('Parcela.pago', $label); ?>
                                                    <?php
                                                } else {
                                                          echo $label;
                                                    ?>

                                                <?php } ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody  role="alert" aria-live="polite" aria-relevant="all">
                                        <?php foreach ($parcela as $key => $value) { ?>
                                            <tr class="gradeX odd">
                                                <td>

                                                    <input id="check_box_<?php echo $value['Parcela']['id'] ?>" 
                                                           name="data[<?php echo $key ?>]" value="<?php echo $value['Parcela']['id'] ?>" class="css-checkbox" type="checkbox" />
                                                    <label for="check_box_<?php echo $value['Parcela']['id'] ?>" name="check_box_<?php echo $value['Parcela']['id'] ?>" class="css-label">
                                                    </label>

                                                </td>
                                                <td><div class="btn-group">
                                                        <button class="btn btn-small btn-primary" data-toggle="dropdown"> <i class="icon-cog"></i> <?php echo __('Escolha') ?><span class="caret"></span> </button>
                                                        <ul class="dropdown-menu">
                                                          
                                                            <?php if ($value['Parcela']['pago'] == 'Não') { ?>
                                                            <li> <a id="id-pago-<?php echo $value['Parcela']['id'] ?>" class="botaoPago" href="#"> <i class="icon-ok"></i><?php echo __('Pagar') ?></a> </li>

                                                              <li> <a target="_blank" href="<?php echo $this->Html->url(array("controller" => "ConfigsBoletos", "action" => "boletoCef", $value['Parcela']['id'] )); ?>"> <i class="icon-barcode"></i><?php echo __('Ver Boleto') ?></a> </li>
                                                            <li class="divider"></li>
                                                            <?php  } ?>

                                                            <li> <a class="botaoPagoSelecionados" href="#"><i class="icon-ok"></i><?php echo __('Pagar selecionados') ?></a> </li>
                                                            

                                                        </ul>
                                                    </div></td>

                                                   <td class="hidden-phone"><?php echo $value['Parcela']['data']  ?></td>   
                                                <td><?php echo $value['Parcela']['valor'] ?></td>
                                                <td class="hidden-phone">

                                                    <span <?php  ($value['Parcela']['pago'] == 'Não') ? print ' class="label label-important" ' : print ' class="label label-success" ' ; ?> ><?php  echo  $value['Parcela']['pago']?></span> 
                                                </td>
                                               
                                            </tr>

                                            <!--Informações modal-->
                                        <div id="modal<?php echo $value['Parcela']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $value['Parcela']['id'] ?>" aria-hidden="true"> </div>

                                    <?php } ?>
                                    <?php if ($totalRegistros <= 0) { ?>
                                        <tr  class="gradeX odd">
                                            <td  colspan="5"><div style="text-align:center">
                                                <?php echo __('Nenhum registro encontrado') ?>!</td>
                                        </tr>
                                    <?php } ?>

                                    

                                    </tbody>

                                </table>

                                <!-- dependecia id da venda -->
                                 <input type="hidden" name="data[idVenda]" value="<?php (!empty($parcela[0]['Venda']['id'])) ? print $parcela[0]['Venda']['id'] : null ;  ?>">
                            </form>
                          
                          
                           
                            <?php if ($totalRegistros >= 1) { ?>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="dataTables_info"><?php echo $this->Paginator->counter(array('format' => __('Página %page% de %pages%, mostrando %current% registros de um total de %count%, indo do registro %start% até o %end%'))); ?></div>
                                    </div>
                                    <div class="span6">
                                        <div class="dataTables_paginate paging_bootstrap pagination">
                                            <ul>

                                                 <!--Paginação-->
                                                 <?php echo $this -> element('paginacao',array('tipo'=>'')); ?>

                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!--http://bootboxjs.com/documentation.html--> 

<!--Ação ajax de pago um único registro por vez--> 
<script>
    $(document).ready(function() {

        $('.botaoPago').live("click", function() {

            var id = $(this).attr('id');
            id = id.replace("id-pago-", "");

            bootbox.dialog({
                message: "<?php echo __('Você realmente deseja pagar esta parcela'); ?>?",
                title: "<?php echo __('Confirmação') ?>",
                buttons: {
                    success: {
                        label: "<?php echo __('Pagar') ?>",
                        className: "btn btn-success",
                        callback: function() {

                            $('#carregandoInfo').show();

                            //Redirecionamento
                            $(location).attr('href','<?php echo $this->Html->url('/'); ?>parcelas/pagar/' + id+'/<?php echo $parcela[0]['Venda']['id'] ?>');
        
                            return true;

                        }
                    },
                    danger: {
                        label: "Não",
                        className: "btn",
                        callback: function() {
                            return true;
                        }
                    }
                }
            })

        })
    });

</script> 


<!-- ação de ocultar caixa de sucesso no topo do site--> 
<?php echo $this->element('scriptOcultaMsgSucesso'); ?>

<!-- Ação e marcar todas as checkboxs -->
<?php echo $this->element('scriptCheckAllCheckBox'); ?>

<!-- importe do plugin validator -->
<?php echo $this -> Html -> script('jquery.validate'); ?>
<?php echo $this -> Html -> script('jquery.validate.msg-'.$usuario['Config']['idioma']); ?>
<!--http://bootboxjs.com/documentation.html--> 
<!-- ação de pago todos os marcados da checkbox -->
<script>
        //formulário
        $("#formDados").validate({

        //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>

        });

    $(document).ready(function() {

        $('.botaoPagoSelecionados').live("click", function() {


            bootbox.dialog({
                message: "<?php echo __('Você realmente deseja pagar estes parcelas') ?>?",
                title: "Confirmação",
                buttons: {
                    success: {
                        label: "<?php echo __('Pagar') ?>",
                        className: "btn btn-success",
                        callback: function() {

                            $('#carregandoInfo').show();
                            $('#pagar_selecionados').submit();

                        }
                    },
                    danger: {
                        label: "<?php echo __('Não') ?>",
                        className: "btn",
                        callback: function() {
                            return true;
                        }
                    }
                }
            })

        })
    });

</script>


