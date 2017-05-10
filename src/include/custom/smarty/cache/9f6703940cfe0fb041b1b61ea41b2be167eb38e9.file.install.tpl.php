<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:46:03
         compiled from "/Users/max/sitograph/src/templates/default/install.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1012790514590b827bab6770-86527187%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f6703940cfe0fb041b1b61ea41b2be167eb38e9' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/install.tpl',
      1 => 1493927162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1012790514590b827bab6770-86527187',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b827baec2f0_84042278',
  'variables' => 
  array (
    'page' => 0,
    'htmlHead' => 0,
    'message_error' => 0,
    'message_success' => 0,
    'install_step' => 0,
    'configList' => 0,
    'configName' => 0,
    'configValue' => 0,
    'modulesList' => 0,
    'moduleName' => 0,
    'modulesListRemote' => 0,
    'admin_login' => 0,
    'admin_password' => 0,
    'htmlFooter' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b827baec2f0_84042278')) {function content_590b827baec2f0_84042278($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
</title>
	<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['page']->value['keywords'];?>
">
	<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['page']->value['description'];?>
">

    <?php echo $_smarty_tpl->tpl_vars['htmlHead']->value;?>

  </head>
<body bgcolor="F7F7F7">

<div class="container" style="padding:50px 100px 0px 100px;">
<h2 style="color:#bebebe;text-align:center;">Sitograph CMS</h2>
<div class="well">
<form class="form-horizontal" method="POST">



<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
<div style="border:1px solid #f00;padding:15px;color:#500;">
<?php echo $_smarty_tpl->tpl_vars['message_error']->value;?>

</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
<div style="border:1px solid #0f0;padding:15px;color:#050;">
<?php echo $_smarty_tpl->tpl_vars['message_success']->value;?>

</div>
<?php }?>


<?php if ($_smarty_tpl->tpl_vars['install_step']->value===1) {?>

	<p class="text-center">
	<h1>Welcome to Sitograph installation wizard</h1>
	</p>

	<p class="text-center" style="margin:50px 0;">
	<input type="submit" value="Start installation" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="2">  
	</p>

<?php } elseif ($_smarty_tpl->tpl_vars['install_step']->value===2) {?>
<p class="lead">
Before getting started, we need to setup <b>config.php</b> in the root directory.<br>
Sample config <b>config-sample.php</b> is being used when config.php is not present.
</p>

<?php  $_smarty_tpl->tpl_vars['configValue'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['configValue']->_loop = false;
 $_smarty_tpl->tpl_vars['configName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['configList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['configValue']->key => $_smarty_tpl->tpl_vars['configValue']->value) {
$_smarty_tpl->tpl_vars['configValue']->_loop = true;
 $_smarty_tpl->tpl_vars['configName']->value = $_smarty_tpl->tpl_vars['configValue']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['index']++;
?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['index']>=5) {?>
<div class="form-group collapse">
<?php } else { ?>
<div class="form-group">
<?php }?>

<label for="imsv_<?php echo $_smarty_tpl->tpl_vars['configName']->value;?>
" class="col-sm-4 control-label"><?php echo $_smarty_tpl->tpl_vars['configName']->value;?>
</label>
<div class="col-sm-8">
	<input type="text" class="form-control" name="msv_<?php echo $_smarty_tpl->tpl_vars['configName']->value;?>
" id="imsv_<?php echo $_smarty_tpl->tpl_vars['configName']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['configValue']->value;?>
" style="width:95%;">
</div>
</div>

<?php } ?>
<p class="text-right">
<a href="#" data-toggle="collapse" data-target=".form-group.collapse">More settings</a>
</p>
	
	<p class="text-center">
	<input type="submit" value="Continue" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="3">  
	</p>
	
	
<?php } elseif ($_smarty_tpl->tpl_vars['install_step']->value===3) {?>


<h2 class="text-center">Install modules</h2>

<p class="lead">
Once you press "<b>Continue</b>" each of modules will be installed.<br>
Installation process includes creation of database tables and default website.
</p>

<div>

<div style="text-align:left;float:left;width:50%;">
<p><u>Local modules to install</u>: </p>
<?php  $_smarty_tpl->tpl_vars['moduleInfo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['moduleInfo']->_loop = false;
 $_smarty_tpl->tpl_vars['moduleName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['modulesList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['moduleInfo']->key => $_smarty_tpl->tpl_vars['moduleInfo']->value) {
$_smarty_tpl->tpl_vars['moduleInfo']->_loop = true;
 $_smarty_tpl->tpl_vars['moduleName']->value = $_smarty_tpl->tpl_vars['moduleInfo']->key;
?> 
<input type="checkbox" name="modules_local[]" checked value="<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
">
<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
<br>
<?php } ?>
</div>


<div style="text-align:left;float:left;width:50%;">
<p><u>Remote modules to install</u>: </p>
<?php  $_smarty_tpl->tpl_vars['moduleName'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['moduleName']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['modulesListRemote']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['moduleName']->key => $_smarty_tpl->tpl_vars['moduleName']->value) {
$_smarty_tpl->tpl_vars['moduleName']->_loop = true;
?> 
<input type="checkbox" name="modules_remote[]" checked value="<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
">
<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
<br>
<?php } ?>
</div>

</div>

<br style="clear:both;">

<hr>

<h2 class="text-center">Create Administrator account</h2>


<div class="form-group">
<div class="col-sm-offset-5 col-sm-7">
  <div class="checkbox">
    <label>
      <input type="checkbox" name="admin_create" value="1" checked> Add Administrator account
    </label>
  </div>
</div>
</div>

<div class="form-group">
<label for="iadmin_login" class="col-sm-5 control-label">Administrator Email</label>
<div class="col-sm-7">
  <input type="email" class="form-control" id="iadmin_login" name="admin_login" value="<?php echo $_smarty_tpl->tpl_vars['admin_login']->value;?>
" placeholder="Email">
</div>
</div>

<div class="form-group">
<label for="iadmin_password" class="col-sm-5 control-label">Administrator Password</label>
<div class="col-sm-7">
  <input type="text" class="form-control" id="iadmin_password" name="admin_password" value="<?php echo $_smarty_tpl->tpl_vars['admin_password']->value;?>
">
</div>
</div>

<p class="text-info">
<b>Note!</b> Administrator will receive email once account is created.
</p>

	<p class="text-center">
	<input type="submit" value="Continue" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="4">  
	</p>
	

<?php } elseif ($_smarty_tpl->tpl_vars['install_step']->value===4) {?>



<h1>Congratulations! Installation successful!</h1>


	<p class="text-center">
	<input type="submit" value="Reload page to start using website" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="5">  
	</p>


<?php } else { ?>


something went wrong



<?php }?>




</form>


<p class="text-muted">
Step: <?php echo $_smarty_tpl->tpl_vars['install_step']->value;?>

</p>

</div>



<?php if ($_smarty_tpl->tpl_vars['install_step']->value>1) {?>
<p>
<form method="POST">
<input type="submit" value="Reset installation" name="install_reset" class="btn btn-danger">  
<input type="hidden" name="install_step" value="1">  
</form>
</p>
<?php }?>


</div>	

<h4 style="color:#bebebe;text-align:center;">
<a href='http://sitograph.com/' target="_blank">Sitograph 5.2</a> 
developed using 
<a href='http://doc.msvhost.com/' target="_blank">MSV Framework 1.0</a></h4>

<?php echo $_smarty_tpl->tpl_vars['htmlFooter']->value;?>


</body>
</html><?php }} ?>
