
var fotoCanvas = $('#fotoCanvas').attr("value");
        var foto = $('#arquivoFoto').attr("value");
        
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

         var fotoCanvas = $('#fotoCanvas').attr("value");

            var foto = $('#arquivoFoto').attr("value");

            if (fotoCanvas == "" && foto == "") {
               
                $('.alert').show();
                $('#infoAlerta').html('<?php echo __("Foto é obrigatório, escolha uma das formas de imagem, foto upload ou webcam") ?>');
                $('html,body').animate({scrollTop: 0}, 'slow');
                return false;//  não envia formulário

            } else {

                if (fotoCanvas != "" && foto != "") {
               
                    $('.alert').show();
                    $('#infoAlerta').html( '<?php echo __("Escolha apenas uma das formas de imagem, foto upload ou webcam") ?>');
                    $('html,body').animate({scrollTop: 0}, 'slow');
                    return false;//  não envia formulário

                } else {

                    if (foto != "") {

                        //msg
                        if (fun_validaExtensaoFoto(foto)) {

                            $('.alert').show();
                            $('#infoAlerta').html('<?php echo __("Extensão de imagem inválida. Só se pode fazer upload de arquivos com extensões: .JPG, .JPEG ou .PNG") ?>');
                            $('html,body').animate({scrollTop: 0}, 'slow');
                            return false;//  não envia formulário

                        }

                    }
                }
            }
