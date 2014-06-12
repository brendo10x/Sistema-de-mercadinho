

<div id="main-content" > 
    <!--início #main-content-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title"><?php echo $titulo ?></h3>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo $this->Html->url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
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
                                    <form id="formDados" action="<?php echo $this->Html->url(array("controller" => "fornecedores", "action" => "listar", "buscar")); ?>" method="post">
                                       <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">
                                        <input class="span6" autocomplete="off" required="required" placeholder="<?php echo __('Pesquisa aqui') ?>..." type="text" name="data[buscar]" value="<?php (!empty($busca)) ? print $busca  : null; ?>" aria-controls="sample_1" class="input-medium">
                                        
                                    </form>
                                </div>
                            </div>
                            <form id="excluir_selecionados"  action="<?php echo $this->Html->url(array("controller" => "fornecedores", "action" => "excluir_selecionados")); ?>" method="post">
                                <table class="table table-striped table-bordered dataTable" >
                                    <span style="display:none" id="carregandoInfo" ><img src="<?php echo $this->Html->url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 1%;"> 

                                                <input id="check" class="css-checkbox" type="checkbox" />
                                                <label for="check" class="css-label"></label>

                                            </th>
                                            <th style="width: 5%;"><?php echo __('Operações') ?></th>
                                            <?php $label = __('Nome'); ?>
                                            <th class="sorting" role="columnheader" style="width: 62%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this->Paginator->sort('Pessoa.pes_nome', $label); ?>
                                                    <?php
                                                } else {

                                                          echo $label;
                                                     ?>

                                                <?php } ?>
                                            </th>
                                            <?php $label = __('Telefone'); ?>
                                            <th class="hidden-phone sorting" style="width: 42%;"> <?php if ($totalRegistros >= 1) { ?>

                                                    <?php echo $this->Paginator->sort('Pessoa.pes_telefone', $label); ?>
                                                    <?php
                                                } else {
                                                          echo $label;
                                                    ?>

                                                <?php } ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody  role="alert" aria-live="polite" aria-relevant="all">
                                        <?php foreach ($fornecedores as $key => $value) { ?>
                                            <tr class="gradeX odd">
                                                <td>

                                                    <input id="check_box_<?php echo $value['Fornecedor']['id'] ?>" 
                                                           name="data[<?php echo $key ?>]" value="<?php echo $value['Fornecedor']['id'] ?>" class="css-checkbox" type="checkbox" />
                                                    <label for="check_box_<?php echo $value['Fornecedor']['id'] ?>" name="check_box_<?php echo $value['Fornecedor']['id'] ?>" class="css-label">
                                                    </label>

                                                </td>
                                                <td><div class="btn-group">
                                                        <button class="btn btn-small btn-primary" data-toggle="dropdown"> <i class="icon-cog"></i> <?php echo __('Escolha') ?><span class="caret"></span> </button>
                                                        <ul class="dropdown-menu">
                                                            <li> <a class="botaoVisualizar" id="id-visualizar-<?php echo $value['Fornecedor']['id'] ?>" href="#modal<?php echo $value['Fornecedor']['id'] ?>" role="button"  data-toggle="modal"> <i class="icon-eye-open"></i><?php echo __('Visualizar') ?></a> </li>
                                                            <li> 
                                                                <a href="<?php echo $this->Html->url(array("controller" => "fornecedores", "action" => "editar", $value['Fornecedor']['id'])); ?>">
                                                                    <i class="icon-edit"></i><?php echo __('Atualizar') ?></a> </li>
                                                            <li> <a id="id-excluir-<?php echo $value['Fornecedor']['id'] ?>" class="botaoExcluir" href="#"> <i class="icon-trash"></i><?php echo __('Excluir') ?></a> </li>
                                                            <li class="divider"></li>
                                                            <li> <a href="<?php echo $this->Html->url(array("controller" => "fornecedores", "action" => "novo")); ?>"> <i class="icon-plus"></i><?php echo __('Adicionar') ?></a> </li>
                                                            <li> <a class="botaoExcluirSelecionados" href="#"><i class="icon-trash"></i><?php echo __('Excluir selecionados') ?></a> </li>
                                                        </ul>
                                                    </div></td>
                                                <td><?php echo $value['Pessoa']['pes_nome'] ?></td>
                                                <td class="hidden-phone"><?php echo $value['Pessoa']['pes_telefone'] ?></td>
                                            </tr>

                                            <!--Informações modal-->
                                        <div id="modal<?php echo $value['Fornecedor']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $value['Fornecedor']['id'] ?>" aria-hidden="true"> </div>

                                    <?php } ?>
                                    <?php if ($totalRegistros <= 0) { ?>
                                        <tr  class="gradeX odd">
                                            <td  colspan="4"><div style="text-align:center">
                                                <?php echo __('Nenhum registro encontrado') ?>!</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>

                                </table>
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
<?php echo $this -> Html -> script('jquery.validate.msg-'.$usuario['Config']['idioma']); ?>

<!-- ação ajax de visualizar registro -->
<script type="text/javascript">
//formulário
        $("#formDados").validate({

          //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>

        });
 
</script> 

<!--Visualizar -->
<?php echo $this->element('scriptVisualizar', array("controle" => "fornecedores")); ?>

<!--http://bootboxjs.com/documentation.html--> 
<!--Ação de excluir um único registro com caixa de diálogo--> 
<?php echo $this->element('scriptExcluir', array("controle" => "fornecedores")); ?>

<!-- ação de ocultar caixa de sucesso no topo do site--> 
<?php echo $this->element('scriptOcultaMsgSucesso'); ?> 

<!-- Ação e marcar todas as checkboxs -->
<?php echo $this->element('scriptCheckAllCheckBox'); ?>

<!--http://bootboxjs.com/documentation.html--> 
<!-- ação de excluir todos os marcados da checkbox -->
<?php echo $this->element('scriptExcluirSelecionados'); ?>


