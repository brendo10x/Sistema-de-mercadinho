

<div id="main-content" > 
    <!--início #main-content-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title"><?php echo $titulo ?></h3>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo $this -> Html -> url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
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
                                    <form id="formDados"  action="<?php echo $this -> Html -> url(array("controller" => "vendas", "action" => "listar", "buscar")); ?>" method="post">
                                        
                                            <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">
                                            <input class="span3 data_datepicker" required="required" type="text" value="<?php (!empty($busca)) ? print $busca : null; ?>" name="data[buscar]"  placeholder="<?php echo __('Pesquisa aqui') ?>..." />
                                         
                                    </form>
                                </div>
                            </div>
 
                            <form id="excluir_selecionados"  action="<?php echo $this -> Html -> url(array("controller" => "vendas", "action" => "excluir_selecionados")); ?>" method="post">
                                <table class="table table-striped table-bordered dataTable" >
                                    <span style="display:none" id="carregandoInfo" ><img src="<?php echo $this -> Html -> url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 1%;"> 

                                                <input id="check" class="css-checkbox" type="checkbox" />
                                                <label for="check" class="css-label"></label>

                                            </th>
                                            <th style="width: 5%;"><?php echo __('Operações') ?></th>
                                            <?php $label = __('Total'); ?>
                                            <th class="sorting" role="columnheader" style="width: 30%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this -> Paginator -> sort('Venda.ven_total', $label); ?>
                                                    <?php
                                                    } else {

                                                    echo $label;
                                                     ?>

                                                <?php } ?>
                                            </th>
                                            <?php $label = __('Forma de pagamento'); ?>
                                            <th class="hidden-phone sorting" style="width: 30%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this -> Paginator -> sort('Venda.ven_forma_pagamento', $label); ?>
                                                    <?php
                                                    } else {
                                                    echo $label;
                                                    ?>

                                                <?php } ?>
                                            </th>
                                            <?php $label = __('Data'); ?>
                                            <th class="hidden-phone sorting" style="width: 35%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this -> Paginator -> sort('Venda.data', $label); ?>
                                                    <?php
                                                    } else {
                                                    echo $label;
                                                    ?>

                                                <?php } ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody  role="alert" aria-live="polite" aria-relevant="all">
                                        <?php foreach ($vendas as $key => $value) { ?>
                                            <tr class="gradeX odd">
                                                <td>

                                                    <input id="check_box_<?php echo $value['Venda']['id'] ?>" 
                                                           name="data[<?php echo $key ?>]" value="<?php echo $value['Venda']['id'] ?>" class="css-checkbox" type="checkbox" />
                                                    <label for="check_box_<?php echo $value['Venda']['id'] ?>" name="check_box_<?php echo $value['Venda']['id'] ?>" class="css-label">
                                                    </label>

                                                </td>
                                                <td><div class="btn-group">
                                                        <button class="btn btn-small btn-primary" data-toggle="dropdown"> <i class="icon-cog"></i> <?php echo __('Escolha') ?><span class="caret"></span> </button>
                                                        <ul class="dropdown-menu">
                                                            <li> <a class="botaoVisualizar" id="id-visualizar-<?php echo $value['Venda']['id'] ?>" href="#modal<?php echo $value['Venda']['id'] ?>" role="button"  data-toggle="modal"> <i class="icon-eye-open"></i><?php echo __('Visualizar') ?></a> </li>
                                                            
                                                            <?php if ($value['Venda']['ven_forma_pagamento'] == __('Prazo')) { ?>
                                                             <li> <a   href="<?php echo $this -> Html -> url(array("controller" => "parcelas", "action" => "listar", $value['Venda']['id'])); ?>"  > <i class="icon-tags"></i><?php echo __('Parcelas') ?></a> </li>
                                                            <?php  } ?>

                                                            <li> <a id="id-excluir-<?php echo $value['Venda']['id'] ?>" class="botaoExcluir" href="#"> <i class="icon-trash"></i><?php echo __('Excluir') ?></a> </li>
                                                            <li class="divider"></li>
                                                            <li> <a href="<?php echo $this -> Html -> url(array("controller" => "vendas", "action" => "novo")); ?>"> <i class="icon-plus"></i><?php echo __('Adicionar') ?></a> </li>
                                                            <li> <a class="botaoExcluirSelecionados" href="#"><i class="icon-trash"></i><?php echo __('Excluir selecionados') ?></a> </li>
                                                        </ul>
                                                    </div></td>
                                                <td><?php echo $value['Venda']['ven_total'] ?></td>
                                                <td class="hidden-phone"><?php echo $value['Venda']['ven_forma_pagamento'] ?></td>
                                                 <td class="hidden-phone"><?php echo $value['Venda']['data']  ?></td>
                                            </tr>

                                            <!--Informações modal-->
                                        <div id="modal<?php echo $value['Venda']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $value['Venda']['id'] ?>" aria-hidden="true"> </div>

                                    <?php } ?>
                                    <?php if ($totalRegistros <= 0) { ?>
                                        <tr  class="gradeX odd">
                                            <td  colspan="5"><div style="text-align:center">
                                                <?php echo __('Nenhum registro encontrado') ?>!</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>

                                </table>
                            </form>
                          
                          
                           
                            <?php if ($totalRegistros >= 1) { ?>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="dataTables_info"><?php echo $this -> Paginator -> counter(array('format' => __('Página %page% de %pages%, mostrando %current% registros de um total de %count%, indo do registro %start% até o %end%'))); ?></div>
                                    </div>
                                    <div class="span6">
                                        <div class="dataTables_paginate paging_bootstrap pagination">
                                            <ul>

                                                <!--Paginação-->
                                                 <?php echo $this -> element('paginacao',array('tipo' => 'buscar')); ?>
                                                 
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

<!-- importe do plugin validator --> 
<?php echo $this -> Html -> script('jquery.validate'); ?> 
<?php echo $this -> Html -> script('jquery.validate.msg-' . $usuario['Config']['idioma']); ?>

<!-- ação ajax de visualizar registro -->
<script type="text/javascript">
     //formulário
    $("#formDados").validate({

     //validator opções
     <?php echo $this -> element('validatorOpcoes'); ?>
   });

</script> 

<!--Visualizar -->
<?php echo $this -> element('scriptVisualizar', array("controle" => "vendas")); ?>

<!--http://bootboxjs.com/documentation.html--> 
<!--Ação de excluir um único registro com caixa de diálogo--> 
<?php echo $this -> element('scriptExcluir', array("controle" => "vendas")); ?>

<!-- ação de ocultar caixa de sucesso no topo do site--> 
<?php echo $this -> element('scriptOcultaMsgSucesso'); ?>

<!-- Ação e marcar todas as checkboxs -->
<?php echo $this -> element('scriptCheckAllCheckBox'); ?>

<!--http://bootboxjs.com/documentation.html--> 
<!-- ação de excluir todos os marcados da checkbox -->
<?php echo $this -> element('scriptExcluirSelecionados'); ?>

