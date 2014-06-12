<!--Select das cidades-->
<?php echo $this -> Html -> script('jquery-1.6.1'); ?>
<script type="text/javascript">
	    $(function(){
	$('#cod_estados').change(function() {

	if ($(this).val()) {
	$('#cod_cidades').hide();
	$('.carregando').show();

	$.getJSON('<?php echo $this -> Html -> url('/'); ?>cidades/buscarJson?', {
	term : $(this).val()
	}, function(item) {
	var cidade = item[0].Cidade
	var options = '';
	for (var i = 0; i < cidade.length; i++) {
	options += '<option value="' + cidade[i].id + '">' + cidade[i].cid_nome + '</option>';
	}

	$('#cod_cidades').html(options).show();
	$('.carregando').hide();
	});
	} else {

	$('#cod_cidades').show();
	$('#cod_cidades').html('<option value="">-- <?php echo __('Escolha um estado antes') ?>
        --</option>');
        }

        });
        });
</script>