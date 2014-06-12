

<div id="container" class="row-fluid">
	<!--Início #container-->

<div id="sidebar" class="nav-collapse collapse">
	<!--Início #sidebar-->
	<div class="sidebar-toggler hidden-phone"></div>
	
	<ul class="sidebar-menu">
		<li class="has-sub <?php ( isset($inicio_menu)) ? print $inicio_menu : print ""; ?>">

			<a href="<?php echo $this -> Html -> url('/'); ?>" class=""><span class="icon-box"><i class="icon-dashboard"></i></span><?php echo __('Início') ?></a>
		</li>

		<?php 

			//recupero permissões
			$permissao = $this->Session->read('Auth.User.Permissoes');

        	//recupero o tipo de usuário ativo na sessão
            $tipoDeUsuario = $this->Session->read('Auth.User.Usuario.tipo');
		
		 ?>


		 <!-- permitido (0 - sim) (1 = não) -->
		 <!-- tipo (0 - proprietário) (1 - vendedor) -->

		 <?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['VendedoresController']['permitido'] == 0) {  ?>

		<li class="has-sub <?php ( isset($vendedor_menu)) ? print $vendedor_menu : print ""; ?>">
			<a href="javascript:;" class=""><span class="icon-box"><i class="icon-user"></i></span> <?php echo __('Vendedores')?><span class="arrow"></span></a>
			<ul class="sub <?php ( isset($vendedor_menu)) ? print $vendedor_menu : print ""; ?> ">
				<li class="<?php ( isset($vendedor_novo_sub_menu)) ? print $vendedor_novo_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'vendedores', 'action' => 'novo')); ?>"><?php echo __('Adicionar') ?></a>
				</li>
					<li class="<?php ( isset($vendedor_listar_sub_menu)) ? print $vendedor_listar_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'vendedores', 'action' => 'listar')); ?>"><?php echo __('Listar') ?></a>
				</li>

			</ul>
		</li>

		<?php  } ?>

		 <?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['ClientesController']['permitido'] == 0) {  ?>

		<li class="has-sub <?php ( isset($cliente_menu)) ? print $cliente_menu : print ""; ?>">
			<a href="javascript:;" class=""><span class="icon-box"><i class="icon-user"></i></span> <?php echo __('Clientes')?> <span class="arrow"></span></a>
			<ul class="sub <?php ( isset($cliente_menu)) ? print $cliente_menu : print ""; ?>">
				<li class="<?php ( isset($cliente_novo_sub_menu)) ? print $cliente_novo_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'clientes', 'action' => 'novo')); ?>"><?php echo __('Adicionar') ?></a>
				</li>
				<li class="<?php ( isset($cliente_listar_sub_menu)) ? print $cliente_listar_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'clientes', 'action' => 'listar')); ?>"><?php echo __('Listar') ?></a>
				</li>

			</ul>
		</li>

		<?php  } ?>
		
		<?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['FornecedoresController']['permitido'] == 0) {  ?>	

		<li class="has-sub <?php ( isset($fornecedor_menu)) ? print $fornecedor_menu : print ""; ?>">
			<a href="javascript:;" class=""><span class="icon-box"><i class="icon-bookmark"></i></span> <?php echo __('Fornecedores')?> <span class="arrow"></span></a>
			<ul class="sub <?php ( isset($fornecedor_menu)) ? print $fornecedor_menu : print ""; ?>">
				<li class="<?php ( isset($fornecedor_novo_sub_menu)) ? print $fornecedor_novo_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'fornecedores', 'action' => 'novo')); ?>"><?php echo __('Adicionar') ?></a>
				</li>
				<li class="<?php ( isset($fornecedor_listar_sub_menu)) ? print $fornecedor_listar_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'fornecedores', 'action' => 'listar')); ?>"><?php echo __('Listar') ?></a>
				</li>

			</ul>
		</li>

		<?php  } ?>
		
		<?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['ProdutosController']['permitido'] == 0) {  ?>

		<li class="has-sub <?php ( isset($produto_menu)) ? print $produto_menu : print ""; ?>">
			<a href="javascript:;" class=""><span class="icon-box"><i class="icon-tags"></i></span><?php echo __('Produtos') ?> <span class="arrow"></span></a>
			<ul class="sub <?php ( isset($produto_menu)) ? print $produto_menu : print ""; ?>">
				<li class="<?php ( isset($produto_novo_sub_menu)) ? print $produto_novo_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'produtos', 'action' => 'novo')); ?>"><?php echo __('Adicionar') ?></a>
				</li>
				<li class="<?php ( isset($produto_listar_sub_menu)) ? print $produto_listar_sub_menu : print ""; ?>">
					<a class="" href="<?php echo $this -> Html -> url(array('controller' => 'produtos', 'action' => 'listar')); ?>"><?php echo __('Listar') ?></a>
				</li>
			</ul>
		</li>

		<?php  } ?>

		<?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['VendasController']['permitido'] == 0) {  ?>

		<li class="has-sub <?php ( isset($venda_menu)) ? print $venda_menu : print ""; ?>">
			<a href="javascript:;" class=""><span class="icon-box"><i class="icon-shopping-cart"></i></span> <?php echo __('Vendas') ?> <span class="arrow"></span></a>
			<ul class="sub <?php ( isset($venda_menu)) ? print $venda_menu : print ""; ?>">
				<li class="<?php ( isset($venda_novo_sub_menu)) ? print $venda_novo_sub_menu : print ""; ?>">
					<a href="<?php echo $this -> Html -> url(array('controller' => 'vendas', 'action' => 'novo')); ?>"><?php echo __('Adicionar') ?></a>
				</li>
				<li class="<?php ( isset($venda_listar_sub_menu)) ? print $venda_listar_sub_menu : print ""; ?>">
					<a  href="<?php echo $this -> Html -> url(array('controller' => 'vendas', 'action' => 'listar')); ?>"> <?php echo __('Listar') ?></a>
				</li>
			</ul>
		</li>

		<?php  } ?>

		<?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['FinanceirosController']['permitido'] == 0) {  ?>

		<li class="has-sub <?php ( isset($financia_menu)) ? print $financia_menu : print ""; ?>">
			<a href="<?php echo $this -> Html -> url(array('controller' => 'financeiros', 'action' => 'index')); ?>" class=""><span class="icon-box"><i class="icon-money"></i></span><?php echo __('Financeiro') ?> </a>
		</li>

		<?php  } ?>

		<?php if ( $tipoDeUsuario == 0 || $tipoDeUsuario == 1 && $permissao['RelatoriosController']['permitido'] == 0) {  ?>

		<li class="has-sub <?php ( isset($relatorios_menu)) ? print $relatorios_menu : print ""; ?>">
			<a href="javascript:;" class=""><span class="icon-box"><i class="icon-bar-chart"></i></span><?php echo __('Relatórios') ?> <span class="arrow"></span></a>
			<ul class="sub <?php ( isset($relatorios_menu)) ? print $relatorios_menu : print ""; ?>">
				<li class="<?php ( isset($relatorios_vendas_listar_sub_menu)) ? print $relatorios_vendas_listar_sub_menu : print ""; ?>">
					<a  href="<?php echo $this -> Html -> url(array('controller' => 'relatorios', 'action' => 'relatorios_vendas')); ?>"><?php echo __('Relatório vendas') ?> </a>
				</li>
				<li class="<?php ( isset($relatorios_produtos_listar_sub_menu)) ? print $relatorios_produtos_listar_sub_menu : print ""; ?>">
					<a  href="<?php echo $this -> Html -> url(array('controller' => 'relatorios', 'action' => 'relatorios_produtos')); ?>"><?php echo __('Relatório produtos') ?> </a>
				</li>
				<li class="<?php ( isset($relatorios_clientes_listar_sub_menu)) ? print $relatorios_clientes_listar_sub_menu : print ""; ?>">
					<a  href="<?php echo $this -> Html -> url(array('controller' => 'relatorios', 'action' => 'relatorios_clientes')); ?>"><?php echo __('Relatório clientes') ?> </a>
				</li>
				  
			</ul>
		</li>

		<?php  } ?>

		<li>
			<a class="" href="<?php echo $this->Html->url(array("controller" => "usuarios", "action" => "logout")); ?>"><span class="icon-box"><i class="icon-user"></i></span><?php echo __('Sair') ?></a>
		</li>
	</ul>
</div><!--Fim #sidebar-->