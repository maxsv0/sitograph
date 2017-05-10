<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:39
  from "/Users/max/sitograph/src/templates/default/404.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c3fb1e9e6_81695005',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e7cf549b208cac1f0e84b686fedcc862af1a0473' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/404.tpl',
      1 => 1493668897,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c3fb1e9e6_81695005 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
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
	
<?php if ($_smarty_tpl->tpl_vars['document']->value) {
echo $_smarty_tpl->tpl_vars['document']->value['text'];?>

<?php }?>
		
</td>
</tr>
</table>

</body>
</html><?php }
}
