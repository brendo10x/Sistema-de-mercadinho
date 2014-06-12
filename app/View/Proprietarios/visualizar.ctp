
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
                    <?php echo $this->html->image($proprietario['Pessoa']['pes_foto'], array('width' => '150px'))?>
                </td>
              </div>
            </div>
            <div class="span10">
              <h4><?php  echo  $proprietario['Pessoa']['pes_nome']?><br />
              </h4>
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td class="span2">CPF:</td>
                    <td><?php  echo  $proprietario['Pessoa']['pes_cpf_ou_cnpj']?></td>
                  </tr>
                  <tr>
                    <td class="span2"><?php echo __('Telefone') ?>:</td>
                    <td> <?php  echo  $proprietario['Pessoa']['pes_telefone']?></td>
                  </tr>
                  <tr>
                    <td class="span2">Email:</td>
                    <td><?php  echo  $proprietario['Pessoa']['pes_cpf_ou_cnpj']?> </td>
                  </tr>
                  <tr>
                    <td class="span2"><?php echo __('Sexo') ?>:</td>
                      <?php $sexo = array(0=>__('Masculino'),1=>__('Feminino')) ?>
                    <td> <?php ( $proprietario['Pessoa']['pes_sexo'] == 0) ? print $sexo[0]: print $sexo[1] ; ?> </td>
                  </tr>
                </tbody>
              </table>
            
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
