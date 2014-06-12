 errorClass: "help-inline",
    highlight: function(element, errorClass) {
    //explicando o closet -> http://jquerybrasil.org/uso-dos-metodos-parent-parents-ou-closest/
         //destaca o erro
         $(element).closest('div.control-group').removeClass("success");
         $(element).closest('div.control-group').addClass("error");

     },
     unhighlight: function(element, errorClass, validClass) {
    //destaca sucesso
    $(element).closest('div.control-group').removeClass("error");
    $(element).closest('div.control-group').addClass("success");
    
    }