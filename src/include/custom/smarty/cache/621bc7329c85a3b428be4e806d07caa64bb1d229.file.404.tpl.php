<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:28
         compiled from "/Users/max/sitograph/src/templates/default/404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1015274739590b5ee0163f74-12650892%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '621bc7329c85a3b428be4e806d07caa64bb1d229' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/404.tpl',
      1 => 1493668897,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1015274739590b5ee0163f74-12650892',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
    'document' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5ee0192bc2_39281446',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5ee0192bc2_39281446')) {function content_590b5ee0192bc2_39281446($_smarty_tpl) {?><!DOCTYPE html>
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
  </head>
<body style="background-color:#333746;">
<style>

h1,h2 {color:#74c4d4;}

</style>

<table align="center" height="100%" width="600" cellpadding="0" cellspacing="0" style="min-height:600px;">
<tr>
<td align="left" valign="middle">

<?php if ($_smarty_tpl->tpl_vars['document']->value['name']) {?>
<h1><?php echo $_smarty_tpl->tpl_vars['document']->value['name'];?>
</h1>
<?php }?>
	
<?php if ($_smarty_tpl->tpl_vars['document']->value) {?>
<?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>

<?php }?>
		
</td>
</tr>
</table>

</body>
</html><?php }} ?>
