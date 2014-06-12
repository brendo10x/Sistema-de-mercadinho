
<div id="main-content">
    <!--início #main-content-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title"><?php $titulo ?> </h3>
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
            <strong><?php echo __('Sucesso') ?>!</strong> <?php echo $this->Session->read('sucesso') ?>. 
        </div>

        <?php } ?>


        <form id="formDados" action="<?php echo $this->Html->url(array("controller" => "proprietarios", "action" => "editar")); ?>" enctype="multipart/form-data" method="post">
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


                                <div  class="form-horizontal" >
                                    <div class="span12">
                                        <div class="tabbable tabbable-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"> <a href="#tab_1_1" data-toggle="tab"><?php echo __('Foto Upload') ?></a> </li>
                                                <li> <a href="#tab_1_2" data-toggle="tab"><?php echo __('Webcam') ?></a> </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1_1">
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
                                                                            <div class="fileupload fileupload-<?php (!empty($proprietario['Pessoa']['pes_foto'])) ? print "exists"  : print "new"; ?>" data-provides="fileupload">

                                                                                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">

                                                                                    <img src="<?php echo $this->Html->url('/img/photo.jpg'); ?>" alt="" /> </div>
                                                                                    <div  class="fileupload-preview fileupload-exists thumbnail"  style="max-width: 200px; max-height: 150px; line-height: 20px;" >
                                                                                       <img src="<?php echo $this->Html->url('/img/') ?><?php echo $proprietario['Pessoa']['pes_foto'] ?>" alt="" />
                                                                                   </div>
                                                                                   <div><span class="btn btn-file"><span class="fileupload-new"><?php echo __('Selecione uma foto') ?></span><span class="fileupload-exists"><?php echo __('Trocar') ?></span>
                                                                                    <input  id="arquivoFoto" name="data[Pessoa][foto][0]"  type="file" class="default" />
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
                                                <!-- tab_1_1 -->

                                                <div class="tab-pane" id="tab_1_2">
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
                                                                    <h6 id="labelCamDisponivel" ><i class="icon-ok"></i> <?php echo __('Câmeras disponível') ?> </h6>
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
                                                                        <p id="confirmaCanvas" class="btn btn-small btn-primary" > 
                                                                            <?php echo __('Confirmar foto') ?>! </p>
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
                                                                    <!--Oculta ocultaConteudoCanvas--> 

                                                         <!--Script foto webcam--> 
                                                <?php echo $this -> element('webcam'); ?>

<input name="data[Pessoa][foto][1]" id="fotoCanvas" type="hidden" value="" />
</div>
<!-- fim tab_1_2--> 




</div>
<!-- fim tab-content--> 
</div>
<!-- fim tabbable tabbable-custom--> 

</div>
<!-- fim span12-->

<div class="control-group">
    <label class="control-label"><?php echo __('Nome') ?>: </label>
    <div class="controls ">
        <input type="text"  required="required" value="<?php echo $proprietario['Pessoa']['pes_nome']  ?>" name="data[Pessoa][pes_nome]" class="span8"  />

    </div>
</div>


<div class="control-group ">
    <label class="control-label"><?php echo __('Selecione sexo') ?>: </label>
    <div class="controls">
        <select class="span5" name="data[Pessoa][pes_sexo]">
            <option <?php ($proprietario['Pessoa']['pes_sexo'] == 0) ? print ' selected="selected" '  : print ''; ?> value="0"><?php echo __('Masculino') ?></option>
            <option <?php ($proprietario['Pessoa']['pes_sexo'] == 1) ? print ' selected="selected" '  : print ''; ?>  value="1"><?php echo __('Feminino') ?></option>
        </select>
    </div>
</div>


<div class="control-group">
    <label class="control-label"> CPF: </label>
    <div class="controls">
        <input type="text" value="<?php echo $proprietario['Pessoa']['pes_cpf_ou_cnpj'] ?>" name="data[Pessoa][pes_cpf_ou_cnpj]" class="span5"  maxlength="14"  />

    </div>
</div>



<div class="control-group">
    <label class="control-label"><?php echo __('Telefone') ?>: </label>
    <div class="controls">
        <input type="text" value="<?php echo $proprietario['Pessoa']['pes_telefone'] ?>"  name="data[Pessoa][pes_telefone]" class="span5"  data-mask="(99)9999-9999" placeholder=""   />
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
                <h4><i class="icon-reorder"></i><?php echo __('Informações de usuário') ?></h4>
                <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
                <div class="widget-body form">
                    <div class="form-horizontal" />

                    
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Email') ?>: </label>
                        <div class="controls">
                            <input name="data[Usuario][email]" value="<?php echo $proprietario['Usuario']['email']  ?>"  type="text" class="span5" />

                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label"><?php echo __('Senha') ?>: </label>
                        <div class="controls">
                            <input name="data[Usuario][senha]" minLength="3"  required="required" value="<?php echo $proprietario['Usuario']['senha'] ?>"  type="password" class="span5 tooltips" data-trigger="hover" data-original-title="<?php echo __('Sua senha é').' : '. $proprietario['Usuario']['senha'] ?>" />
                            
                        </div>
                    </div>
                    <div class="form-actions">
                       <button   type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
                   </div>

                   <input type="hidden" name="data[Usuario][tipo]" value="0" />

               </div>
           </div>
       </div>



       <!-- envio as dependências-->
       <input type="hidden" name="data[Proprietario][id]" value="<?php echo $proprietario['Proprietario']['id'];  ?>" />
       <input type="hidden" name="data[Pessoa][id]" value="<?php echo $proprietario['Pessoa']['id'];  ?>" />  
       <input type="hidden" name="data[Usuario][id]" value="<?php echo $proprietario['Usuario']['id'];  ?>" />  

       <!-- envio as dependências-->
       <input type="hidden" name="data[Pessoa][pes_foto]" value="<?php echo $proprietario['Pessoa']['pes_foto'];  ?>" s/>          

   </div>
</div>
</form>
<!--fim formulário-->

</div>
</div>
<!--fim #main-content--> 

<?php echo $this -> Html -> script('jquery.validate'); ?>
<?php echo $this->Html->script('jquery.validate.msg-'.$usuario['Config']['idioma']); ?>

<script type="text/javascript">
 // tutorial explicando http://tiagobutzke.wordpress.com/2010/11/17/plugin-validate-do-jquery-com-ajax-e-php/
 // outro http://jqueryvalidation.org/

 //adiciona novos métodos de validação
 $.validator.addMethod("emailSeExiste",function(value,element,param){

    var result = ajaxEmailSeExiste(element,<?php echo $proprietario['Usuario']['id']; ?>); 

    return (param == eval(result));

});

 $.validator.addMethod("validaCPF",function(value,element,param){

    var result = ajaxValidaCPF(element); 
    
    return (param == eval(result));

});

 $.validator.addMethod("CPFouCNPJseExiste",function(value,element,param){

    var result = ajaxCPFouCNPJSeExiste(element,<?php echo $proprietario['Pessoa']['id']; ?>); 
    
    return (param == eval(result));

});



     //formulário
     $("#formDados").validate({

        //evento acionado quando do enviar o formulário
        submitHandler: function(form) {

        //regra de validação de foto customizado
          //valida foto
        <?php echo $this -> element('validaFotoEditar'); ?>

        $(form).ajaxSubmit();// envia formulário


    },

            //validator opções
           <?php echo $this -> element('validatorOpcoes'); ?>,
           
//regras de validação
rules: {
    "data[Usuario][email]": { 
        emailSeExiste: true
    },"data[Pessoa][pes_cpf_ou_cnpj]": { 
        validaCPF:true,
        CPFouCNPJseExiste:true      

    }
}


});

//verifica no servidor se existe algum email que o usuário digitou
function ajaxEmailSeExiste(element,id) {

    var result = $.ajax({
        type: "POST",
        url: '<?php echo $this->Html->url('/'); ?>usuarios/verificaEmailEditar',
        data: 'data[email]='+element.value+'&data[id]='+id,
        async: false,
        global: false,
    }).responseText;

     //retorna true ou false
     return result;
 }

 //verifica se o cpf/cnpj é válido
 function ajaxValidaCPF(element) {

    var result = $.ajax({
        type: "POST",
        url: '<?php echo $this->Html->url('/'); ?>pessoas/ajaxValidaCPF',
        data: 'data[pes_cpf_ou_cnpj]='+element.value,
        async: false,
        global: false,
    }).responseText;

     //retorna true ou false
     return result;
 }

 //verifica no servidor se existe algum cpf/cnpj que o usuário digitou
 function ajaxCPFouCNPJSeExiste(element,id) {

    var result = $.ajax({
        type: "POST",
        url: '<?php echo $this->Html->url('/'); ?>pessoas/ajaxCPFouCNPJSeExisteEditar',
        data: 'data[pes_cpf_ou_cnpj]='+element.value+'&data[id]='+id,
        async: false,
        global: false,
    }).responseText;

    return result;
}

</script>

