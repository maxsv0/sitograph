<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:46:52
         compiled from "/Users/max/sitograph/src/templates/default/widget/messages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:115306902590b852cc887c6-03502765%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78083cefcbc1b31b0909589ccc830c999e8e2bfb' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/messages.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115306902590b852cc887c6-03502765',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message_error' => 0,
    'message_success' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b852cc8dbd7_61640401',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b852cc8dbd7_61640401')) {function content_590b852cc8dbd7_61640401($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
<div class="row">

<div class="alert alert-danger">
<?php echo $_smarty_tpl->tpl_vars['message_error']->value;?>

</div>

</div>
<?php }?>


<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
<div class="row">

<div class="alert alert-success">
<?php echo $_smarty_tpl->tpl_vars['message_success']->value;?>

</div>

</div>
<?php }?><?php }} ?>
