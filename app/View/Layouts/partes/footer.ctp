
</div><!--Início #container-->
<div id="footer">
	2013 &copy; <?php echo __('Iníciado')  ?> no dia 16/Dezembro/2013 - Segunda-feira
	<div class="span pull-right">
		<span class="go-top"><i class="icon-arrow-up"></i></span>
	</div>
</div>

</div>

<!--arquivos js scripts-->
<?php

// plugins e biblioteca jquery
echo $this -> Html -> script('jquery-1.8.3.min');?>
 <!--bootstrap fundamental-->
<script type="text/javascript"  src="<?php echo $this -> Html -> url('/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<?php
echo $this -> Html -> script('jquery-ui');

// datapiker calendário fundamental
echo $this -> Html -> script('jquery-ui-datapiker-'.$usuario['Config']['idioma']);
?>
 

<?php

// importânte plugins para o cálculo automática da venda
echo $this -> Html -> script('jquery.calculation.min');
echo $this -> Html -> script('jquery.calculation');
echo $this -> Html -> script('jquery.field');

?>

<?php

//caixa de dialogo muito importânte
echo $this -> Html -> script('bootbox');

?>

<!-- usado no upload das fotos - interagir com o usuário -->
<script type="text/javascript"  src="<?php echo $this -> Html -> url('/assets/bootstrap/js/bootstrap-fileupload.js'); ?>"></script>


<!--Máscaras ex: 999-9/9 = 145-2/7 -->
<script type="text/javascript"  src="<?php echo $this -> Html -> url('/assets/bootstrap-inputmask/bootstrap-inputmask.min.js'); ?>"></script>
<?php echo $this -> Html -> script('scripts'); ?>

<!--Configura página de template -->
<script>
jQuery(document).ready(function() {
	App.setMainPage(true);
	App.init()
}); 
</script>

</body>
</html>

