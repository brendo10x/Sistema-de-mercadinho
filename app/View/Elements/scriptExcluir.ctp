<script>
    $(document).ready(function() {

        $('.botaoExcluir').live("click", function() {

            var id = $(this).attr('id');
            id = id.replace("id-excluir-", "");

            bootbox.dialog({
                message: "<?php echo __('Você realmente deseja excluir este item'); ?>?",
                title: "<?php echo __('Confirmação') ?>",
                buttons: {
                    success: {
                        label: "<?php echo __('Excluir') ?>",
                        className: "btn btn-danger",
                        callback: function() {

                            $('#carregandoInfo').show();

                            //Redirecionamento
                            $(location).attr('href','<?php echo $this->Html->url('/'); ?><?php echo $controle ?>/excluir/' + id);
        
                            return true;

                        }
                    },
                    danger: {
                        label: "Não",
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