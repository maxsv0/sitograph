<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:44
  from "/Users/max/sitograph/src/templates/default/sitograph-login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c442e3f25_35916475',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f354e5aae9eb6239a73340526b63c433c0426653' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph-login.tpl',
      1 => 1493649254,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c442e3f25_35916475 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>

<head>
<title>Панель управления</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/css/sitograph.css" />

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/js/default.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/js/bootstrap.min.js"><?php echo '</script'; ?>
>

<link href="/favicon.ico" rel="shortcut icon">
</head>


<body style="background: url(<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/sitograph/bg.gif) repeat-x #FFFFFF;padding-top:10px;">




<table align="center" cellpadding="0" cellspacing="0" width="940" height="100%">
<tr>
	<td valign="top" width="139">
	&nbsp;
	</td>
	<td>
	
	
	<table align="center" cellpadding="0" cellspacing="0" width="326">
	<tr>
		<td style="padding-bottom: 50px;" align="center">
		<p>
			<img src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/sitograph/sitograph-logo-dark-<?php if ($_smarty_tpl->tpl_vars['lang']->value == "ru" || $_smarty_tpl->tpl_vars['lang']->value == "ua") {?>ru<?php } else { ?>en<?php }?>.png" style="height:80px;">
		</p>
		<h4><?php echo _t("cms");?>
</h4>
		</td>
	</tr>
	<tr>
		<td style="padding: 0px 0px 10px 20px; font-size: 14px;">

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
<span style="color: #EE1A3B;"><?php echo $_smarty_tpl->tpl_vars['message_error']->value;?>
</span>
<?php } else { ?>
	<?php echo _t("form.wellcome");?>

<?php }?>
		
		</td>
	</tr>
	<tr>
		<td style="background: url(<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/sitograph/login_plain.png) 0 0 no-repeat; padding: 1px 3px 5px 3px;" height="206">
		
<form action="/admin/login/" method="POST" id="login_form">
		<table align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td style="padding-bottom: 4px;"><?php echo _t("form.login");?>
</td>
		</tr>
		<tr>
			<td style="padding-bottom: 11px;"><input class="login_form" type="text" name="email" value="" style="width: 280px;"></td>
		</tr>
		<tr>
			<td style="padding-bottom: 4px;"><?php echo _t("form.password");?>
</td>
		</tr>
		<tr>
			<td style="padding-bottom: 37px;"><input class="login_form" type="password" name="password" value="" style="width: 280px;"></td>
		</tr>
		<tr>
			<td><input type="submit" class="loginbtn" value="<?php echo _t("btn.login");?>
"></td>
		</tr>
		</table>
<input type="hidden" name="doLogin" value="1">
</form>
		
		</td>
	</tr>
	</table>
	
	
	</td>
	<td width="139">
	</td>
</tr>
</table>







<?php echo $_smarty_tpl->tpl_vars['htmlFooter']->value;?>


</body>
</html><?php }
}
