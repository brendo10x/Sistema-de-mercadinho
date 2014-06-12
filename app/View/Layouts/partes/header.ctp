
<html lang="pt-BR"><!--<![endif]--><!-- head -->
<head>
	
	<title><?php echo $titulo ?></title>
	

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<!--arquivos css-->
	<link rel="stylesheet" href="<?php echo $this -> Html -> url('/assets/bootstrap/css/bootstrap.min.css'); ?>"/>
	<link rel="stylesheet"  href="<?php echo $this -> Html -> url('/assets/bootstrap/css/bootstrap-responsive.min.css'); ?>"/>
	<link rel="stylesheet"  href="<?php echo $this -> Html -> url('/assets/bootstrap/css/bootstrap-fileupload.css'); ?>" />
	<link rel="stylesheet"  href="<?php echo $this -> Html -> url('/assets/font-awesome/css/font-awesome.css'); ?>"/>

	 
	<?php

    echo $this -> Html -> css('style.min');
    echo $this -> Html -> css('style_responsive');

    //configuração de estilo
    echo $this -> Html -> css($usuario['Config']['tema']);

    echo $this -> fetch('meta');
    echo $this -> fetch('css');
    echo $this -> fetch('script');
    echo $this -> Html -> meta('icon');

    // css fundamental datapiker, autocomplete, 
    echo $this -> Html -> css('jquery-ui');
	?>
  

	<?php
    //script
    echo $this -> Html -> script('jquery-1.10.2');
    
	?>
	
	<?php echo $this -> Html -> script('jquery.validate'); ?>
    <?php echo $this->Html->script('jquery.validate.msg-'.$usuario['Config']['idioma']); ?>
    
</head>

<body class="fixed-top">


	<?php

    //recupero permissões
    $permissao = $this -> Session -> read('Auth.User.Permissoes');

    //recupero o tipo de usuário ativo na sessão
    $tipoDeUsuario = $this -> Session -> read('Auth.User.Usuario.tipo');
	?>
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php echo $this -> Html -> url("/"); ?>"><?php echo $this->html->image($usuario['Config']['foto_sistema'])?></a><a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="arrow"></span></a>
				
                 

				<div class="top-nav ">
					<ul class="nav pull-right top-menu">
                    
						
                        
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->html->image($usuario['Pessoa']['pes_foto'], array('width' => '45px','height'=>'45px'))?><span class="username"><?php echo $usuario['Pessoa']['pes_nome'] ?></span><b class="caret"></b></a>
							<ul class="dropdown-menu">

								<!-- tipo (0 - proprietário) (1 - vendedor) -->
								<?php if ($usuario['Usuario']['tipo'] == 0) { ?>
								<li>
									<a href="<?php echo $this -> Html -> url(array("controller" => "proprietarios", "action" => "editar", $usuario['Proprietario']['id'])); ?>"><i class="icon-user"></i> <?php echo __('Editar perfil') ?> </a>
								</li>

								<li> <a class="botaoVisualizar" id="id-visualizar-proprietario-<?php echo $usuario['Proprietario']['id'] ?>" href="#modal<?php echo $usuario['Proprietario']['id'] ?>" role="button"  data-toggle="modal"> <i class="icon-eye-open"></i> <?php echo __('Visualizar') ?></a> 
								</li>


								<li>
									<a href="<?php echo $this -> Html -> url(array("controller" => "Permissoes", "action" => "permitir")); ?>"><i class="icon-unlock"></i> <?php echo __('Permissões') ?></a>
								</li>
								

								<li>
									<a href="<?php echo $this -> Html -> url(array("controller" => "configs", "action" => "configuracao")); ?>"><i class="icon-wrench"></i> <?php echo __('Config. sistema') ?></a>
								</li>
								
								<?php } ?>

								<!-- Permissão de usuário -->
								<?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['ConfigsBoletosController']['permitido'] == 0) { ?>
								
								<li>
									<a href="<?php echo $this -> Html -> url(array("controller" => "configsBoletos", "action" => "configuracaoBoleto")); ?>"><i class="icon-barcode"></i> <?php echo __('Config. boleto') ?></a>
								</li>
								<li class="divider"></li>
								<?php  } ?>
								
								<li>
									<a href="<?php echo $this -> Html -> url(array("controller" => "usuarios", "action" => "logout")); ?>"><i class="icon-key"></i> <?php echo  __('Sair')?> </a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- tipo (0 - proprietário) (1 - vendedor) -->
	<?php if ($usuario['Usuario']['tipo'] == 0) { ?>

	<div id="modal<?php echo $usuario['Proprietario']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $usuario['Proprietario']['id'] ?>" aria-hidden="true"> </div>

	<!-- ação ajax de visualizar registro -->
	<script type="text/javascript">
	        $(document).ready(function() {
		$('.botaoVisualizar').live("click", function() {

			var id = $(this).attr('id');
			id = id.replace("id-visualizar-proprietario-", "");

			$.ajax({
				type: 'get',
				url: '<?php echo $this -> Html -> url('/'); ?>proprietarios/visualizar?term=' + id,
				success: function(retorno) {
					$('#modal' + id).html(retorno);
				}
			})

		})
	});

	</script> 
	<?php } ?>

