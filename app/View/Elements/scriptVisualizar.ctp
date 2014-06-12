<script>
    
      $(document).ready(function() {
        $('.botaoVisualizar').live("click", function() {

            var id = $(this).attr('id');
            id = id.replace("id-visualizar-", "");

            $.ajax({
                type: 'get',
                url: '<?php echo $this->Html->url('/'); ?><?php echo $controle ?>/visualizar?term=' + id,
                success: function(retorno) {
                    $('#modal' + id).html(retorno);
                }
            })

        })
    });

</script>