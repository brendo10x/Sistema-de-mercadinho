
<div id="main-content">
    <!--início #main-content-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title"><?php echo $titulo ?></h3>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo $this->Html->url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
                    <li> <a href="#"><?php echo $titulo ?> </a><span class="divider-last">&nbsp;</span> </li>
                </ul>
            </div>
        </div>

        <?php if ($this -> Session -> check('sucesso')) { ?>

            <div class="alert alert-success">
                <button class="close" data-dismiss="alert"> x </button>
                <strong><?php echo __('Sucesso') ?>!</strong> <?php echo $this -> Session -> read('sucesso') ?>. 
            </div>

        <?php } ?>

        <form id="formDados" action="<?php echo $this->Html->url(array("controller" => "fornecedores", "action" => "novo")); ?>" enctype="multipart/form-data" method="post">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i><?php echo __('Informações básicas') ?></h4>
                            <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>


                        <div class="widget-body form">

                            <div style="display:none" class="alert alert-error">
                                <button class="close" data-dismiss="alert"> × </button>
                                <strong><?php echo __('Atenção') ?>!</strong> 
                                <span id="infoAlerta"></span>.
                            </div>


                            <div action="#" class="form-horizontal" >
                                <div class="span12">
                                    <div class="tabbable tabbable-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"> <a href="#tab_1_1" data-toggle="tab"><?php echo __('Webcam') ?></a> </li>
                                            <li> <a href="#tab_1_2" data-toggle="tab"><?php echo __('Foto Upload') ?></a> </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1_1">

                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="widget">
                                                            <div class="widget-title">
                                                                <h4><i class="icon-camera"></i><?php echo __('Webcam') ?></h4>
                                                            </div>
                                                            <div class="widget-body">
                                                                <div id="webcam"></div>
                                                                <div id="webcamBotoes" style="margin-top: 2%"> <a id="capturaCanvas1" href="javascript:webcam.capture(3);changeFilter();void(0);" class="btn btn-small btn-primary" > <?php echo __('Tire uma foto após 3 segundos') ?> </a> <a id="capturaCanvas2" href="javascript:webcam.capture();changeFilter();void(0);" class="btn btn-small" > <?php echo __('Tire uma foto instantaneamente') ?></a> </div>


                                                                <h6><i class="icon-bullhorn"> </i><span id="status"></span></h6>
                                                                <h6 id="labelCamDisponivel" ><i class="icon-ok"></i> <?php echo __('Câmeras disponíveis') ?> </h6>
                                                                <ul id="cams">
                                                                </ul>
                                                                <span id="carregandoInfoWebcam" ><img src="<?php echo $this->Html->url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="ocultaConteudoCanvas"  class="span6">
                                                        <div class="widget">
                                                            <div class="widget-title">
                                                                <h4><i class="icon-picture"></i> <?php echo __('Foto') ?></h4>
                                                            </div>
                                                            <div class="widget-body">
                                                                <canvas id="canvas" height="240" width="320"></canvas>
                                                                <div style="margin-top: 2%">
                                                                    <p id="confirmaCanvas" class="btn btn-small btn-primary" > <?php echo __('Confirmar foto') ?>! </p>
                                                                    <p id="naoConfirmaCanvas" class="btn btn-small" > <?php echo __('Não confirmar foto') ?>! </p>
                                                                    <h6 id="msgFotoNaoconfirmadaCanvas">
                                                                        <p class="label label-warning"> <?php echo __('Atenção') ?>: </p>
                                                                        <?php echo __('Por favor, confirme foto para que possa ser salva no sistema') ?>! </h6>
                                                                    <h6 id="msgFotoconfirmadaCanvas">
                                                                        <p class="label label-success"> <?php echo __('Sucesso') ?>: </p>
                                                                        <?php echo __('Foto confirmada com sucesso pronta para ser salva no sistema') ?>! </h6>
                                                                    <h6>
                                                                        <p class="label label-danger"> <?php echo __('Info') ?>: </p>
                                                                        <?php echo __('Toda foto tirada aqui é salva em .PNG com dimensão A: 240px e L: 320px') ?>! </h6>
                                                                </div>
                                                            </div>
                                                            <!--Oculta ocultaConteudoCanvas--> 

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--row-fluid--> 

                                            </div>
                                            <!-- tab_1_1 -->

                                            <div class="tab-pane" id="tab_1_2">

                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="widget">
                                                            <div class="widget-title">
                                                                <h4><i class="icon-camera"></i> <?php echo __('Foto Upload') ?></h4>
                                                            </div>
                                                            <div class="widget-body">
                                                                <div class="control-group">
                                                                    <label class="control-label"></label>
                                                                    <div class="controls">
                                                                        <div class="fileupload fileupload-<?php (!empty($img)) ? print "exists"  : print "new"; ?>" data-provides="fileupload">
                                                                            <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="<?php echo $this->Html->url('/img/photo.jpg'); ?>" alt="" /> </div>
                                                                            <div  class="fileupload-preview fileupload-exists thumbnail"  style="max-width: 200px; max-height: 150px; line-height: 20px;" >
                                                                            </div>
                                                                            <div><span class="btn btn-file"><span class="fileupload-new"><?php echo __('Selecione uma foto') ?></span><span class="fileupload-exists"><?php echo __('Trocar') ?></span>
                                                                                    <input  id="arquivoFoto" name="data[Pessoa][foto][0]" type="file" class="default" />
                                                                                </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo __('Remover') ?></a> </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <h6>
                                                                    <p class="label label-danger"> <?php echo __('Info') ?>: </p>
                                                                    <?php echo __('Escolha uma foto com extensão .PNG ou .JPEG/JPG') ?>! 
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- fim tab_1_2--> 
                                            
                                            <!--Script foto webcam--> 
                                                <?php echo $this -> element('webcam'); ?>

                                            <input name="data[Pessoa][foto][1]" id="fotoCanvas" type="hidden" value="" />

                                        </div>
                                        <!-- fim tab-content--> 
                                    </div>
                                    <!-- fim tabbable tabbable-custom--> 

                                </div>
                                <!-- fim span12-->



                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Nome') ?>: </label>
                                    <div class="controls ">
                                        <input type="text"  minlength="2" required="required" name="data[Pessoa][pes_nome]" class="span8"  />

                                    </div>
                                </div>



                                <div class="control-group ">
                                    <label class="control-label"><?php echo __('Selecione sexo') ?>: </label>
                                    <div class="controls">
                                        <select class="span5" name="data[Pessoa][pes_sexo]">
                                            <option  value="0"><?php echo __('Masculino') ?></option>
                                            <option  value="1"><?php echo __('Feminino') ?></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">CNPJ: </label>
                                    <div class="controls">
                                        <input maxlength="18" required="required"   minlength="18" type="text" name="data[Pessoa][pes_cpf_ou_cnpj]" class="span5"   />

                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Telefone') ?>: </label>
                                    <div class="controls">
                                        <input type="text" required="required"   name="data[Pessoa][pes_telefone]" class="span5"  data-mask="(99)9999-9999" placeholder=""   />

                                    </div>
                                </div>
 
                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Observações') ?>:</label>
                                    <div class="controls">
                                         <textarea name="data[Fornecedor][observacoes]" required="required"  class="span8" rows="3"></textarea>
                                    </div>
                                </div>
                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i><?php echo __('Endereço') ?> </h4>
                            <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
                        <div class="widget-body form">
                            <div class="form-horizontal">

                                <div class="control-group ">
                                    <label class="control-label"><?php echo __('Rua') ?>: </label>
                                    <div class="controls">
                                        <input type="text" required="required"  name="data[Endereco][end_rua]"  class="span5"    />

                                    </div>
                                </div>  


                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Número') ?>: </label>
                                    <div class="controls">
                                        <input type="text" required="required"  name="data[Endereco][end_numero]"   class="span5"    />

                                    </div>
                                </div>  

                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Bairro') ?>: </label>
                                    <div class="controls">
                                        <input type="text" required="required"  name="data[Endereco][end_bairro]"   class="span5" />
                                    </div>
                                </div>


                                <!--Select das cidades-->
                                <?php echo $this -> element('selectCidadeEstado'); ?>
                                

                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Selecione um estado') ?>: </label>
                                    <div class="controls ">
                                        <select name="data[Endereco][estado_id]" id="cod_estados" class="span5" data-placeholder="<?php echo __('Selecione um estado') ?>" tabindex="1">
                                            <option value="">-- <?php echo __('Selecione um estado') ?> --</option>

                                            <?php foreach ($estados as $key => $value) {  ?>

                                                <option  value="<?php echo $value['Estado']['id']; ?>"><?php echo $value['Estado']['est_descricao']; ?> (<?php echo $value['Estado']['est_sigla']; ?>)</option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Selecione uma cidade') ?>: </label>
                                    <div class="controls"> <span class="carregando" style="display: none;">
                                            <img src="<?php echo $this->Html->url('/'); ?>/assets/pre-loader/Fading squares.gif" alt="Fading squares"></span>

                                        <select required="required"  class="span5" name="data[Endereco][cidade_id]" id="cod_cidades">
                                            <option value="">-- <?php echo __('Selecione um estado antes') ?> --</option>

                                        </select>

                                    </div>
                                </div>
                                 <div class="form-actions">
                                         <button   type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

           

                <!-- envio as dependências-->
                <input type="hidden" name="data[Fornecedor][endereco_id]" />
                <input type="hidden" name="data[Fornecedor][pessoa_id]" />
                <input name="data[Pessoa][pes_foto]"  type="hidden" value="" />

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
    // tutorial explicando http://tiagobutzke.wordpress.com/2010/11/17/plugin-validate-do-jquery-com-ajax-e-php/
    // outro http://jqueryvalidation.org/

    //adiciona novos métodos de validação
  
    $.validator.addMethod("validaCNPJ", function(value, element, param) {

        var result = ajaxValidaCNPJ(element);

        return (param == eval(result));
    });
    $.validator.addMethod("CPFouCNPJseExiste", function(value, element, param) {

        var result = ajaxCPFouCNPJSeExiste(element);
 
        return (param == eval(result));
    });


    //formulário
    $("#formDados").validate({

        //evento acionado quando do enviar o formulário
        submitHandler: function(form) {

            //regra de validação de foto customizado
            
             //valida foto
            <?php echo $this -> element('validaFotoAdicionar'); ?>

            $(form).ajaxSubmit(); // envia formulário
        },
        
         //validator opções
        <?php echo $this -> element('validatorOpcoes'); ?>,
     
        //regras de validação
        rules: {
              "data[Pessoa][pes_cpf_ou_cnpj]": {
                validaCNPJ: true,
                CPFouCNPJseExiste: true

            }
        }
    });
    

    //verifica se o cpf/cnpj é válido
    function ajaxValidaCNPJ(element) {

        var result = $.ajax({
            type: "POST",
            url: '<?php echo $this->Html->url('/'); ?>pessoas/ajaxValidaCNPJ',
            data: 'data[pes_cpf_ou_cnpj]=' + element.value,
            async: false,
            global: false,
        }).responseText;

         //retorna true ou false
        return result;
    }

    //verifica no servidor se existe algum cpf/cnpj que o usuário digitou
    function ajaxCPFouCNPJSeExiste(element) {

        var result = $.ajax({
            type: "POST",
            url: '<?php echo $this->Html->url('/'); ?>pessoas/ajaxCPFouCNPJSeExiste',
            data: 'data[pes_cpf_ou_cnpj]=' + element.value,
            async: false,
            global: false,
        }).responseText;

         //retorna true ou false
        return result;
    }

</script>

