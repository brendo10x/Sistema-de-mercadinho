
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

  <form id="formDados" action="<?php echo $this->Html->url(array("controller" => "produtos", "action" => "novo")); ?>"  method="post">

      <div class="row-fluid">
        <div class="span12">
          <div class="widget">
            <div class="widget-title">
              <h4><i class="icon-reorder"></i><?php echo __('Informações') ?></h4>
              <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
              <div class="widget-body form">

                <div class="form-horizontal">

                   <div class="control-group">
                    <label class="control-label"><?php echo __('Nome') ?>: </label>
                    <div class="controls ">
                        <input minlength="2" required="required" type="text"  name="data[Produto][pro_nome]" class="span8"  />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><?php echo __('Preço') ?>: </label>
                    <div class="controls ">
                        <input type="text"  min="2" required="required"  name="data[Produto][pro_preco]" class="span5"  />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"><?php echo __('Quantidade') ?>: </label>
                    <div class="controls ">
                        <input min="1" type="number" required="required" value="1" name="data[Produto][pro_quantidade]" class="span2"  />
                    </div>
                </div>
                 

                <div class="control-group">
                   <label class="control-label"><?php echo __('Tipo') ?>:</label>
                   <div class="controls">
                    <select name="data[Produto][pro_tipo]"  class="span2" >
                       <option  value="0" ><?php echo __('Comida') ?></option>
                       <option  value="1" ><?php echo __('Bebida') ?></option>
                   </select>
               </div>
           </div>

           <div class="control-group">
            <label class="control-label"><?php echo __('Código de barras') ?>: </label>
            <div class="controls ">
                <input type="text" minlength="13" maxlength="13" required="required" name="data[Produto][pro_codigo_barras]" class="span5"  />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo __('Fornecedor') ?>: </label>
            <div class="controls ">
                <input type="text" required="required" autocomplete="off" id="fornecedor"  name="fornecedor" class="span5"  />
            </div>
        </div>

        <img width="140px" height="80px" id="imgFornecedor" src="<?php echo $this->Html->url('/img/photo.jpg'); ?>" alt="" /> 
      <div class="form-actions">
       <button   type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
      </div>
        <!--Autocomplete fornecedor-->
          <?php echo $this -> element('scriptAutocompleteFornecedor'); ?>

<input type="hidden"  id="idFornecedor" name="data[Produto][fornecedor_id]" />

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
<?php echo $this->Html->script('jquery.validate'); ?>
<?php echo $this->Html->script('jquery.validate.msg-'.$usuario['Config']['idioma']); ?>

<script type="text/javascript">
  //formulário
  $("#formDados").validate({

        //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>
 
});


</script>