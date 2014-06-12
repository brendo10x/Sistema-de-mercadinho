
 
<div id="main-content" > 
    <!--início #main-content-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title"><?php echo $titulo ?></h3>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo $this -> Html -> url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
                    <li><a href="<?php echo $this -> Html -> url(array("controller" => "relatorios", "action" => "relatorios_clientes")); ?>"><?php echo $breadcrumb ?></a><span class="divider">&nbsp;</span></li>
                    <li> <a href="#"><?php echo $titulo ?></a><span class="divider-last">&nbsp;</span> </li>
                </ul>
            </div>
        </div>


        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i><?php echo __('Tabela de dados') ?></h4>
                        <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
                        <div class="widget-body">
                            <div class="dataTables_wrapper form-inline" role="grid">

                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="tabbable tabbable-custom tabs-left">
                                            <ul class="nav nav-tabs tabs-left">
                                                <li <?php (!empty($tab_1)) ? print ' class="active" ' : null; ?> > 
                                                    <a href="#tab_3_1" data-toggle="tab"><?php echo __('Clientes por cidade') ?></a>
                                                </li>
                                                <li <?php (!empty($tab_2)) ? print ' class="active" ' : null; ?> > 
                                                    <a href="#tab_3_2" data-toggle="tab"><?php echo __('Clientes por estado') ?></a>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane <?php (!empty($tab_1)) ? print ' active ' : null; ?> " id="tab_3_1">

                                                  <form  action="<?php echo $this -> Html -> url(array("controller" => "relatorios", "action" => "relatorios_clientes")); ?>" method="post">

                                                 <!--Select das cidades-->
                             <?php echo $this -> element('selectCidadeEstado'); ?>


<b><?php echo __('Estado') ?>:</b>
<select   id="cod_estados" name="estado" class="span3" data-placeholder="<?php echo __('Selecione um estado') ?>" tabindex="1">
    <option value=""><?php echo __('Selecione um estado') ?></option>

    <?php foreach ($estados as $key => $value) {  ?>

     <?php  if(!empty($listaCidades['Estado']['id'])) { ?>
        <option  <?php ($value['Estado']['id'] == $listaCidades['Estado']['id']) ? print ' selected="selected" ' : print ''; ?>   value="<?php echo $value['Estado']['id']; ?>"><?php echo $value['Estado']['est_descricao']; ?> (<?php echo $value['Estado']['est_sigla']; ?>)</option>

        <?php }else{ ?>

    <option  value="<?php echo $value['Estado']['id']; ?>"><?php echo $value['Estado']['est_descricao']; ?> (<?php echo $value['Estado']['est_sigla']; ?>)</option>
        <?php } ?>
    <?php } ?>
</select>





<b><?php echo __('Cidade') ?>:</b>
<span class="carregando" style="display: none;">
    <img src="<?php echo $this -> Html -> url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>

    <select class="span3" name="buscar" id="cod_cidades">
       

            <?php if (!empty($listaCidades['Cidade'])) { 

            foreach ($listaCidades['Cidade'] as $key => $value) { ?>

                <option <?php ($value['id'] == $cidadeEscolhida) ? print ' selected="selected" ' : print ''; ?> value="<?php echo $value['id'] ?>"><?php echo $value['cid_nome']; ?></option>        

                <?php } ?>

            <?php }else{ ?>
                     <option value=""><?php echo __('Selecione uma cidade') ?></option>
             <?php } ?>


    </select>

    <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">


</form>

</div>


<div class="tab-pane <?php (!empty($tab_2)) ? print ' active ' : null; ?>"  id="tab_3_2">

   <form  action="<?php echo $this -> Html -> url(array("controller" => "relatorios", "action" => "relatorios_clientes")); ?>" method="post">

    <b><?php echo __('Estado') ?>:</b>
<select name="buscar2" class="span3" data-placeholder="<?php echo __('Selecione um estado') ?>" tabindex="1">
    <option value=""><?php echo __('Selecione um estado') ?></option>

   
    <?php foreach ($estados as $key => $value) {  ?>

     <?php  if(!empty($estadoEcolhido)) { ?>
        <option  <?php ($value['Estado']['id'] == $estadoEcolhido) ? print ' selected="selected" ' : print ''; ?>   value="<?php echo $value['Estado']['id']; ?>"><?php echo $value['Estado']['est_descricao']; ?> (<?php echo $value['Estado']['est_sigla']; ?>)</option>

        <?php }else{ ?>

    <option  value="<?php echo $value['Estado']['id']; ?>"><?php echo $value['Estado']['est_descricao']; ?> (<?php echo $value['Estado']['est_sigla']; ?>)</option>
        <?php } ?>
    <?php } ?>
</select>
    <input type="submit" value="<?php echo __('Buscar') ?>" class="btn">
</form> 
</div>
</div>
</div>


</div><!-- span principal -->
</div>




<form   action="<?php echo $this -> Html -> url(array("controller" => "vendas", "action" => "excluir_selecionados")); ?>" method="post">
    <table class="table table-striped table-bordered dataTable" >
        <span style="display:none" id="carregandoInfo" ><img src="<?php echo $this -> Html -> url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>
        <thead>
            <tr role="row">

                <th style="width: 10%;"><?php echo __('Registro') ?></th>

                <?php $label = __('Cliente'); ?>

                <th class="sorting" role="columnheader" style="width: 25%;"> <?php if ($totalRegistros >= 1) { ?>

                    <?php echo $this -> Paginator -> sort('Pessoa.pes_nome', $label); ?>
                    <?php
                    } else {

                    echo $label;
                  ?>

                  <?php } ?>

              </th>

              <?php $label = __('Estado'); ?>

              <th class=" sorting" role="columnheader" style="width: 45%;"> 
               <?php echo $label  ?>

          </th>

          <?php $label = __('Cidade'); ?>
          <th class=" sorting" style="width: 20%;">  
            <?php   echo $label; ?>
 
      </th>
  </tr>
</thead>
<tbody  role="alert" aria-live="polite" aria-relevant="all">
    <?php foreach ($clientes as $key => $value) { ?>
    <tr class="gradeX odd">


        <td><a class="botaoVisualizar btn btn-small btn-primary" id="id-visualizar-<?php echo $value['Cliente']['id'] ?>" href="#modal<?php echo $value['Cliente']['id'] ?>" role="button"  data-toggle="modal"> <i class="icon-eye-open"></i><?php echo __('Visualizar') ?></a>
        </td>
        <td><?php echo $value['Pessoa']['pes_nome'] ?></td>
        <td ><?php echo $value['est']['est_descricao']  ?></td>
        <td ><?php echo $value['cid']['cid_nome'] ?></td>
    </tr>


    <!--Informações modal-->
    <div id="modal<?php echo $value['Cliente']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $value['Cliente']['id'] ?>" aria-hidden="true"> </div>


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
                <?php echo $this->element('paginacao',array('tipo' => '')); ?>

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

<!--Visualizar -->
<?php echo $this -> element('scriptVisualizar', array("controle" => "clientes")); ?>

</script> 