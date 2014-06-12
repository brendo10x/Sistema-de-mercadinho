
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
if (!empty($sucesso)) { ?>
<div class="alert alert-success">
  <button class="close" data-dismiss="alert"> x </button>
  <strong><?php echo __('Sucesso') ?>!</strong>  <?php echo $sucesso; ?>. </div>
  <?php } ?>

  <form  action="<?php echo $this->Html->url(array("controller" => "Permissoes", "action" => "permitir")); ?>"  method="post">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget">
          <div class="widget-title">
            <h4><i class="icon-reorder"></i><?php echo __('Permissões do usuário vendedor')?></h4>
            <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
            <div class="widget-body form">

              <div class="form-horizontal">


                <?php 

                    //recupero permissões
                    $permissao = $this->Session->read('Auth.User.Permissoes');

                 ?> 


                <!-- Manter vendedores -->
                <div class="control-group">
                   <label class="control-label"><?php echo __('Manter vendedores') ?>:</label>
                   <div class="controls">
                     <select name="data[0][Permissao][permitido]"  class="span2" >
                        <option <?php  ($permissao['VendedoresController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                        <option <?php  ($permissao['VendedoresController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="data[0][Permissao][id]" value="<?php echo $permissao['VendedoresController']['id'] ?>">


            <!-- Manter clientes -->
            <div class="control-group">
               <label class="control-label"><?php echo __('Manter clientes') ?>:</label>
               <div class="controls">
                 <select name="data[1][Permissao][permitido]"  class="span2" >
                    <option <?php  ($permissao['ClientesController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                    <option <?php  ($permissao['ClientesController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
                </select>
            </div>
        </div>
        <input type="hidden" name="data[1][Permissao][id]" value="<?php echo $permissao['ClientesController']['id'] ?>">

        <!-- Manter fornecedores -->
        <div class="control-group">
           <label class="control-label"><?php echo __('Manter fornecedores') ?>:</label>
           <div class="controls">
             <select name="data[2][Permissao][permitido]"  class="span2" >
                <option <?php  ($permissao['FornecedoresController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                <option <?php  ($permissao['FornecedoresController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
            </select>
        </div>
    </div>
    <input type="hidden" name="data[2][Permissao][id]" value="<?php echo $permissao['FornecedoresController']['id'] ?>">

    <!-- Manter produtos -->
        <div class="control-group">
           <label class="control-label"><?php echo __('Manter produtos') ?>:</label>
           <div class="controls">
             <select name="data[3][Permissao][permitido]"  class="span2" >
                <option <?php  ($permissao['ProdutosController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                <option <?php  ($permissao['ProdutosController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
            </select>
        </div>
    </div>
    <input type="hidden" name="data[3][Permissao][id]" value="<?php echo $permissao['ProdutosController']['id'] ?>">

    <!-- Manter vendas -->
        <div class="control-group">
           <label class="control-label"><?php echo __('Manter vendas') ?>:</label>
           <div class="controls">
             <select name="data[4][Permissao][permitido]"  class="span2" >
                <option <?php  ($permissao['VendasController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                <option <?php  ($permissao['VendasController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
            </select>
        </div>
    </div>
    <input type="hidden" name="data[4][Permissao][id]" value="<?php echo $permissao['VendasController']['id'] ?>"> 
    
    <!-- Permitir configuração de boleto -->
        <div class="control-group">
           <label class="control-label"><?php echo __('Permitir config. boleto') ?>:</label>
           <div class="controls">
             <select name="data[5][Permissao][permitido]"  class="span2" >
                <option <?php  ($permissao['ConfigsBoletosController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                <option <?php  ($permissao['ConfigsBoletosController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
            </select>
        </div>
    </div>
    <input type="hidden" name="data[5][Permissao][id]" value="<?php echo $permissao['ConfigsBoletosController']['id'] ?>">

     <!-- Permitir ver finâncias -->
        <div class="control-group">
           <label class="control-label"><?php echo __('Manter financeiro') ?>:</label>
           <div class="controls">
             <select name="data[6][Permissao][permitido]"  class="span2" >
                <option <?php  ($permissao['FinanceirosController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                <option <?php  ($permissao['FinanceirosController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
            </select>
        </div>
    </div>
    <input type="hidden" name="data[6][Permissao][id]" value="<?php echo $permissao['FinanceirosController']['id'] ?>">

    <!-- Permitir ver relatórios -->
        <div class="control-group">
           <label class="control-label"><?php echo __('Manter relatórios') ?>:</label>
           <div class="controls">
             <select name="data[7][Permissao][permitido]"  class="span2" >
                <option <?php  ($permissao['RelatoriosController']['permitido'] == 0) ? print ' selected="selected" ' : print '' ; ?> value="0" ><?php echo __('Sim') ?></option>
                <option <?php  ($permissao['RelatoriosController']['permitido'] == 1) ? print ' selected="selected" ' : print '' ; ?> value="1" ><?php echo __('Não') ?></option>
            </select>
        </div>
    </div>
    <input type="hidden" name="data[7][Permissao][id]" value="<?php echo $permissao['RelatoriosController']['id'] ?>">

</div>

</div>
</div>


<button style="margin-left: 196px;" type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
</div>
</div>


</form>
<!--fim formulário--> 

</div>
</div>
<!--fim #main-content--> 
<p></p>

