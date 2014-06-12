<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">


        <h3 class="page-title"> <?php echo $titulo ?></h3>
        <ul class="breadcrumb">
          <li><a href="<?php echo $this -> Html -> url('/'); ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span></li>

          <li><a href="<?php echo $this -> Html -> url('/'); ?>"><?php echo ('Ir para página principal') ?></a><span class="divider-last">&nbsp;</span></li>
        </ul>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span12">
        <div class="widget">
          <div class="widget-title">
            <h4><i class=" icon-ban-circle"></i> <?php echo  __('Página anterior bloqueada, apenas o proprietário tem acesso')  ?></h4>
            <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span></div>
            <div class="widget-body">
              <div class="error-page">
                <?php echo $this->html->image('500.png')?>
                <h1><strong><?php echo $titulo ?></strong>
                  <br />

                  <a href="<?php echo $this -> Html -> url('/'); ?>" class="btn btn-primary"> <?php echo ('Página principal') ?> </a> </h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>