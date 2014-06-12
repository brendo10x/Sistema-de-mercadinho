<script>
    $(document).ready(function() {

        $('.botaoExcluirSelecionados').live("click", function() {


            bootbox.dialog({
                message: "<?php echo __('Você realmente deseja excluir estes itens') ?>?",
                title: "Confirmação",
                buttons: {
                    success: {
                        label: "<?php echo __('Excluir') ?>",
                        className: "btn btn-danger",
                        callback: function() {

                            $('#carregandoInfo').show();
                            $('#excluir_selecionados').submit();

                        }
                    },
                    danger: {
                        label: "<?php echo __('Não') ?>",
                        className: "btn",
                        callback: function() {
                            return true;
                        }
                    }
                }
            })

        })
    });

</script>