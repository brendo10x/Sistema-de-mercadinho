$(function() {

    $(".datepicker").datepicker({
        dayNames : ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin : ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort : ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort : ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText : 'Próximo',
        prevText : 'Anterior',
        changeMonth : true,
        changeYear : true,
        closeText : 'Pronto',
        currentText : 'Este mês',
        showButtonPanel : true,
        dateFormat : 'yy-mm-dd',
        onChangeMonthYear : function(year, month, inst) {

            $(this).attr('value', month + "-" + year);

        }
    });

});

$(function() {
    $(".data_datepicker").datepicker({
        dayNames : ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin : ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort : ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort : ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText : 'Próximo',
        prevText : 'Anterior',
        changeMonth : true,
        changeYear : true,
        closeText : 'Pronto',
        currentText : 'Este mês',
        showButtonPanel : true,
        dateFormat : 'yy-mm-dd',

    });

});

