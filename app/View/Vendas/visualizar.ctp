
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
                    <?php echo $this->html->image($cliente['Pessoa']['pes_foto'], array('width' => '150px'))?>
                </td>
            </div>
        </div>
        <div class="span10">

          <table class="table table-borderless">
            <tbody>
                <tr>
                    <td class="span2"><?php echo __('Cliente') ?>:</td>
                    <td><?php  echo  $cliente['Pessoa']['pes_nome']?></td>
                </tr>
                <tr>
                    <td class="span2"><?php echo __('CPF') ?>:</td>
                    <td> <?php  echo  $cliente['Pessoa']['pes_cpf_ou_cnpj']?></td> 
                    <tr>
                        <td class="span2"><?php echo __('Telefone') ?>:</td>
                        <td> <?php  echo  $cliente['Pessoa']['pes_telefone']?></td>
                    </tr>
 
                </tbody>
            </table>

        </div>
        <div class="space5"></div>
    </div>

    <div class="widget-body">
        <div class="span5">
          <div class="text-center profile-pic">
            <td >
                <?php echo $this->html->image($vendedor['Pessoa']['pes_foto'], array('width' => '150px'))?>
            </td>
        </div>
    </div>
    <div class="span10">

    </h4>
    <table class="table table-borderless">
        <tbody>
            <tr>
                <td class="span2"><?php echo __('Vendedor') ?>:</td>
                <td><?php  echo  $vendedor['Pessoa']['pes_nome']?></td>
            </tr>
            <tr>
                <td class="span2"><?php echo __('Telefone') ?>:</td>
                <td><?php  echo  $vendedor['Pessoa']['pes_telefone']?></td>
            </tr>
            <tr>
                <td class="span2"><?php echo __('Email') ?>:</td>
                <td><?php  echo  $vendedor['Usuario']['email']?></td>
            </tr>
            
            
        </tbody>
    </table>
    
    <h4><?php (count($parcela) != 0 ) ?  print __('Parcelas') :  print __('Á vista'); ?></h4>
    <div class="well">

        <table class="table table-bordered table-striped">
           <thead>
            <tr>
                <th><?php echo __('Pagamento') ?></th><th><?php echo __('Valor') ?></th> <th><?php echo __('Pago') ?></th> 
            </tr>
        </thead>
        <tbody> 
          <?php if( count($parcela) != 0 ){ ?>

            <?php foreach ($parcela as $key => $valor) { ?>
             <tr>
               <td> <?php echo $valor['Parcela']['data'] ?> </td>
               <td><?php  echo  $valor['Parcela']['valor']?></td>

               <td><span <?php  ($valor['Parcela']['pago'] == 'Não') ? print ' class="label label-important" ' : print ' class="label label-success" ' ; ?> ><?php  echo  $valor['Parcela']['pago']?></span></td>

            </tr>

            <?php } ?>

         <?php }else{ ?>

               <tr>
                <td> <?php echo $venda['Venda']['data'] ?> </td>
                <td><?php  echo  $venda['Venda']['ven_total']?></td>
                <td><span  class="label label-success" ><?php echo __('Sim') ?></span></td>

            </tr>

          <?php } ?>
 
            <tr>
                <td class="span2"><?php echo __('Data venda') ?>:</td>
                <td colspan="3"> <?php  echo  $venda['Venda']['data'] ?></td>
            </tr>
            <tr>
                <td class="span2"><?php echo __('Total venda') ?>:</td>
                <td colspan="3"> <?php  echo  $venda['Venda']['ven_total'] ?></td>
            </tr>


        </tbody> 
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
