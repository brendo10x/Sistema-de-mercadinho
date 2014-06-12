<!DOCTYPE html><!--[if IE 8]><html lang="en" class="ie8"></html><![endif]--><!--[if IE 9]><html lang="en" class="ie9"></html><![endif]--><!--[if !IE]><!--><html lang="en"><!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <title><?php echo $titulo ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <link rel="stylesheet" href="<?php echo $this -> Html -> url('/assets/bootstrap/css/bootstrap.min.css'); ?>"/>
  <link href="<?php echo $this -> Html -> url('/assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet" />
  <?php
  echo $this -> Html -> css('style.min');
  echo $this -> Html -> css('style_responsive');
  echo $this -> Html -> css('style_default');
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body id="login-body">
  <div class="login-header">
    <div id="logo" class="center"><?php echo $this->html->image('uploads/logomarca-sistema.png',array('alt'=>'logo','class'=>'center'))?></div>
  </div>

  
  <!-- Msg de atenção -->
  <?php  $msgAlerta = $this->Session->flash('auth'); 

    if(!empty($msgAlerta)){  ?>

  <div class="alert ">
    <button class="close" data-dismiss="alert"> × </button>
    <strong><?php echo __('Atenção') ?>!</strong> <?php echo  $msgAlerta  ?>.
  </div>

  <?php } ?>

  <!-- Msg de erro -->
  <?php if($this -> Session -> check('erro')){  ?>

  <div class="alert alert-error">
    <button class="close" data-dismiss="alert"> × </button>
    <strong><?php echo __('Erro') ?>!</strong> <?php echo  $this -> Session -> read('erro')  ?>.
  </div>

  <?php } ?>


  <!-- Msg de sucesso -->
  <?php  if ($this->Session->check('sucesso')) { ?>

  <div class="alert alert-success">
    <button class="close" data-dismiss="alert"> x </button>
    <strong><?php echo __('Sucesso') ?>!</strong> <?php echo $this->Session->read('sucesso') ?>. 
  </div>

  <?php } ?>
  
  <div id="login">
    <form id="loginform" class="form-vertical no-padding no-margin" action="<?php echo $this->Html->url(array("controller" => "usuarios", "action" => "login")); ?>" method="post"  />

      <div class="lock"><i class="icon-lock"></i></div>
      <div class="control-wrap">
        <h4><?php echo $titulo ?></h4>
        <div class="control-group">
          <div class="controls">
            <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
              <input id="input-username" name="data[Usuario][email]" type="text" placeholder="<?php echo __('Email') ?>" />
            </div>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <div class="input-prepend"><span class="add-on"><i class="icon-key"></i></span>
              <input id="input-password" name="data[Usuario][senha]"  type="password" placeholder="<?php echo __('Senha') ?>" />
              <!--<input  name="data[usu_tipo]" value="1" type="hidden" /> -->
            </div>
            
          </div>
        </div>
      </div>
      <input type="submit" id="login-btn" class="btn btn-block login-btn" value="<?php echo __('Entrar')  ?>" />
    </form>

    
</div>
<div id="login-copyright"> <?php echo  date('Y')?> &copy; Mercadinho. </div>
<?php echo $this -> Html -> script('jquery-1.8.3.min'); ?>


<script type="text/javascript"   src="<?php echo $this -> Html -> url('/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<?php

echo $this -> Html -> script('jquery.blockui');
echo $this -> Html -> script('scripts');

?>

<script>jQuery(document).ready(function(){App.initLogin()});</script>
</body>
</html>