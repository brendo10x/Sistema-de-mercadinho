<div id="main-content">
	<!--início #main-content-->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">

				
				<h3 class="page-title"> <?php echo __('Painel principal')  ?><small> <?php echo __('informações gerais')  ?> </small></h3>
				<ul class="breadcrumb">
					<li>
						<a href="#"><i class="icon-home"></i></a><span class="divider">&nbsp;</span>
					</li>

					<li>
						<a href="<?php echo $this -> Html -> url('/'); ?>"><?php echo $titulo ?></a><span class="divider-last">&nbsp;</span>
					</li>

				</ul>
			</div>
		</div>

		

		<div id="page" class="dashboard">
			  <div class="row-fluid circle-state-overview">
          <div class="span2 responsive clearfix" data-tablet="span3" data-desktop="span2">
            <div class="circle-wrap">
              <div class="stats-circle turquoise-color"><i class="icon-user"></i></div>
              <p><strong><?php echo $totalUsuarios ?></strong> <?php echo __('Usuários') ?> </p>
            </div>
          </div>
          <div class="span2 responsive" data-tablet="span3" data-desktop="span2">
            <div class="circle-wrap">
              <div class="stats-circle red-color"><i class="icon-tags"></i></div>
              <p><strong><?php echo $totalProdutos ?></strong><?php echo __('Produtos') ?> </p>
            </div>
          </div>
          <div class="span2 responsive" data-tablet="span3" data-desktop="span2">
            <div class="circle-wrap">
              <div class="stats-circle green-color"><i class="icon-shopping-cart"></i></div>
              <p><strong><?php echo $totalVendas ?></strong> <?php echo __('Vendas') ?>   </p>
            </div>
          </div>
          <div class="span2 responsive" data-tablet="span3" data-desktop="span2">
            <div class="circle-wrap">
              <div class="stats-circle gray-color"><i class="icon-bookmark"></i></div>
              <p><strong><?php echo $totalFornecedores ?></strong><?php echo __('Fornecedores') ?> </p>
            </div>
          </div>
          <div class="span2 responsive" data-tablet="span3" data-desktop="span2">
            <div class="circle-wrap">
              <div class="stats-circle purple-color"><i class="icon-user"></i></div>
              <p><strong><?php echo $totalClientes ?></strong><?php echo __('Clientes') ?>  </p>
            </div>
          </div>
          <div class="span2 responsive" data-tablet="span3" data-desktop="span2">
            <div class="circle-wrap">
              <div class="stats-circle blue-color"><i class="icon-user"></i></div>
              <p><strong><?php echo $totalVendedores ?></strong> <?php echo __('Vendedores') ?> </p>
            </div>
          </div>
        </div>

			
		</div>


	</div>
</div>

