
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> × </button>
    <h3 ><?php echo __('Informações') ?></h3>
</div>
<div class="modal-body">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget">
          <div class="widget-title">
            <h4><i class="icon-user"></i><?php echo $tituloJanelaModal ?></h4>
        </div>
        <div class="widget-body">
            <div class="span5">
              <div class="text-center profile-pic">
                <td >
                    <?php echo $this->html->image('/img/codigoBarras/'.$produto['Produto']['pro_codigo_barras'].'.png', array('width' => '150px'))?>
                </td>
            </div>
        </div>
        <div class="span10">
          <h4><?php  echo  $produto['Produto']['pro_nome']?><br />
          </h4>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td class="span2"><?php echo __('Preço') ?>:</td>
                <td><?php  echo  $produto['Produto']['pro_preco']?></td>
            </tr>
            <tr>
                <td class="span2"><?php echo __('Quantidade') ?>:</td>
                <td> <?php  echo  $produto['Produto']['pro_quantidade']?></td>
            </tr>
            <tr>
                <td class="span2"><?php echo __('Código de barras') ?>:</td>
                <td> <?php  echo  $produto['Produto']['pro_codigo_barras']?></td>
            </tr>

            <tr>
                <td class="span2"><?php echo __('Tipo') ?>:</td>
                <?php $tipo = array(0=>__('Comida '),1=>__('Bebida')) ?>
                <td> <?php ( $produto['Produto']['pro_tipo'] == 0) ? print $tipo[0]: print $tipo[1] ; ?> </td>
            </tr>
        </tbody>
    </table>
    <h4><?php echo __('Fornecedor') ?></h4>
    <div class="well">

        <div class="span5">
              <div class="text-center profile-pic">
                <td >
                    <?php echo $this->html->image($produto['Pessoas']['pes_foto'], array('width' => '150px'))?>
                </td>
            </div>
        </div>
        
         <table class="table table-borderless">
            <tr>
                <td class="span2"><?php echo __('Nome') ?>:</td>
                <td> <?php  echo  $produto['Pessoas']['pes_nome']?></td>
            </tr>
            <tr>
                <td class="span2"><?php echo __('Telefone') ?>:</td>
                <td> <?php  echo  $produto['Pessoas']['pes_telefone']?></td>
            </tr>
              <tr>
                <td class="span2">CNPJ:</td>
                <td> <?php  echo  $produto['Pessoas']['pes_cpf_ou_cnpj']?></td>
            </tr>
        </table> 
        

    </div>
</div>
<div class="space5"></div>
</div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php echo __('Fechar') ?> </button>
    
</div>
