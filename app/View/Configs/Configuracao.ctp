
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

      <form id="formDados" action="<?php echo $this->Html->url(array("controller" => "configs", "action" => "configuracao")); ?>" enctype="multipart/form-data"  method="post">

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

                <div class="form-horizontal">

                  <div class="control-group">
                    <label class="control-label"><?php echo __('Logomarca') ?>: </label>
                    <div class="controls">
                      <div class="fileupload fileupload-<?php (!empty($configuracao['Config']['foto_sistema'])) ? print "exists"  : print "new"; ?>" data-provides="fileupload">

                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">

                          <img src="<?php echo $this->Html->url('/img/photo.jpg'); ?>" alt="" /> </div>
                          <div  class="fileupload-preview fileupload-exists thumbnail"  style="max-width: 200px; max-height: 150px; line-height: 20px;" >
                           <img src="<?php echo $this->Html->url('/img/') ?><?php echo $configuracao['Config']['foto_sistema'] ?>" alt="" />
                         </div>
                         <div><span class="btn btn-file"><span class="fileupload-new"><?php echo __('Selecione uma foto') ?></span><span class="fileupload-exists"><?php echo __('Trocar') ?></span>
                          <input  id="arquivoFoto" name="data[Config][foto_sistema]"  type="file" class="default" />
                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo __('Remover') ?></a> </div>
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label"><?php echo __('Nome do sistema') ?>: </label>
                    <div class="controls ">
                      <input type="text" minlength="2" required="required"  value="<?php echo $configuracao['Config']['nome_sistema'] ?>" name="data[Config][nome_sistema]" class="span8"  />

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
                <h4><i class="icon-reorder"></i><?php echo __('Estilos e idiomas') ?></h4>
                <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
                <div class="widget-body form">

                  <div class="form-horizontal">


                    <div class="control-group">
                      <label class="control-label"><?php echo __('Selecione um idioma') ?>:</label>
                      <div class="controls">
                        <select name="data[Config][idioma]" class="span5" >

                         <option <?php  ($configuracao['Config']['idioma'] == "por") ? print ' selected="selected" ' : print '' ; ?> value="por" ><?php echo __('Português') ?></option>
                         <option <?php  ($configuracao['Config']['idioma'] == "eng") ? print ' selected="selected" ' : print '' ; ?> value="eng" ><?php echo __('Inglês') ?></option>


                       </select>
                     </div>
                   </div>

                   <div class="control-group">
                    <label class="control-label"><?php echo __('Selecione um tema') ?>:</label>
                    <div class="controls">
                      <select name="data[Config][tema]" class="span5 "  >

                       <option <?php  ($configuracao['Config']['tema'] == 'style_default') ? print ' selected="selected" ' : print '' ; ?> value="style_default" ><?php echo __('Verde') ?></option>
                       <option <?php  ($configuracao['Config']['tema'] == 'style_gray') ? print ' selected="selected" ' : print '' ; ?> value="style_gray" ><?php echo __('Cinza') ?></option>
                       <option <?php  ($configuracao['Config']['tema'] == 'style_purple') ? print ' selected="selected" ' : print '' ; ?>  value="style_purple" ><?php echo __('Roxo') ?></option>
                       <option <?php  ($configuracao['Config']['tema'] == 'style_navy-blue') ? print ' selected="selected" ' : print '' ; ?> value="style_navy-blue" ><?php echo __('Azul-marinho') ?></option>

                     </select>
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
              <h4><i class="icon-reorder"></i><?php echo __('Paginação') ?></h4>
              <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span> </div>
              <div class="widget-body form">

                <div class="form-horizontal">


                  <div class="control-group">
                    <label class="control-label"><?php echo __('Número de registros') ?>: </label>
                    <div class="controls">
                      <select name="data[Config][registros_por_pagina]" class="span5 popovers" data-trigger="hover" data-content="<?php echo __('Informe o número de registros que serão mostrados a cada página de listar') ?>" data-original-title="<?php echo __('Número de registros') ?>" tabindex="1">

                       <option <?php  ($configuracao['Config']['registros_por_pagina'] == 4) ? print ' selected="selected" ' : print '' ; ?> value="4" >4</option>
                       <option <?php  ($configuracao['Config']['registros_por_pagina'] == 6) ? print ' selected="selected" ' : print '' ; ?> value="6" >6</option>
                       <option <?php  ($configuracao['Config']['registros_por_pagina'] == 8) ? print ' selected="selected" ' : print '' ; ?> value="8" >8</option>
                       <option <?php  ($configuracao['Config']['registros_por_pagina'] == 10) ? print ' selected="selected" ' : print '' ; ?> value="10" >10</option>

                     </select>
                   </div>
                 </div>

                 <div class="control-group">
                  <label class="control-label"><?php echo __('Diferença entre botões') ?>: </label>
                  <div class="controls">
                    <select name="data[Config][diferenca_entre_botoes_pag]" class="span5 popovers" data-trigger="hover" data-content="<?php echo __('Informe a diferença entre os botões na paginação') ?>" data-original-title="<?php echo __('Diferença entre botões') ?>" tabindex="1">

                     <option <?php  ($configuracao['Config']['diferenca_entre_botoes_pag'] == 2) ? print ' selected="selected" ' : print '' ; ?> value="2" >3</option>
                     <option <?php  ($configuracao['Config']['diferenca_entre_botoes_pag'] == 3) ? print ' selected="selected" ' : print '' ; ?> value="3" >4</option>
                     <option <?php  ($configuracao['Config']['diferenca_entre_botoes_pag'] == 7) ? print ' selected="selected" ' : print '' ; ?> value="7" >8</option>
                     <option <?php  ($configuracao['Config']['diferenca_entre_botoes_pag'] == 9) ? print ' selected="selected" ' : print '' ; ?> value="9" >10</option>

                   </select>
                 </div>
               </div>

               <div class="form-actions">
                 <button   type="submit" class="btn btn-success"> <?php echo __('Salvar') ?> </button>
               </div>

             </div>
           </div>
         </div>

         <!-- envio as dependências-->
         <input type="hidden" name="data[Config][id]" value="<?php echo $configuracao['Config']['id'] ?>" />

 

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


 //função de validação da extensão da foto
 function fun_validaExtensaoFoto (caminhoDaFoto) {

         //validação explicação -> http://www.criarweb.com/artigos/validar-extensao-arquivo-a-subir-com-javascript.html
         extensoes_permitidas = new Array(".jpg", ".jpeg", ".png"); 
          //retira a extensão da imagem
          extensao = (caminhoDaFoto.substring(caminhoDaFoto.lastIndexOf("."))).toLowerCase(); 

        //comprovo se a extensão está entre as permitidas 
        for (var i = 0; i < extensoes_permitidas.length; i++) { 
         if (extensoes_permitidas[i] == extensao) { 
           return false;// extensão válida
           break;
         } 
       } 

   return true; // extensão inválida

 }

     //formulário
     $("#formDados").validate({

        //evento acionado quando do enviar o formulário
        submitHandler: function(form) {

        //regra de validação de foto customizado


        var foto = $('#arquivoFoto').attr("value");


        if (foto != "" ) {
                //msg
                if (fun_validaExtensaoFoto(foto)) {

                 $('.alert').show();
                 $('#infoAlerta').html('<?php echo __("Extensão de imagem inválida. Só se pode fazer upload de arquivos com extensões: .JPG, .JPEG ou .PNG") ?>');
                 $('html,body').animate({scrollTop: 0},'slow');

                 return false; //  não envia formulário
               } 


             }  

        $(form).ajaxSubmit();// envia formulário


      },

       //validator opções
       <?php echo $this -> element('validatorOpcoes'); ?>


});

</script>

