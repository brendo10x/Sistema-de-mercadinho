<script type="text/javascript">

    $(document).ready(function() {
        $('#check').live("click", function() {

            if ($('#check').attr('checked') == 'checked') {

                // se o checkbox estiver selecionado quando clicado
                $('.css-checkbox').attr('checked', true); // seleciona toda a classe `check` 

            } else {
                // se não estiver selecionado
                $('.css-checkbox').attr('checked', false); // desmarca a classe `check`
            }

        })
    });

</script> 