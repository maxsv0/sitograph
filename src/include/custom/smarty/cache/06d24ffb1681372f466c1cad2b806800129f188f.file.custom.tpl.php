<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:56:52
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/section/custom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:753759183590b87847589a5-69235424%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06d24ffb1681372f466c1cad2b806800129f188f' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/section/custom.tpl',
      1 => 1489421161,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '753759183590b87847589a5-69235424',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_edit' => 0,
    'list_edit' => 0,
    'list_custom' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b8784789702_13939988',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b8784789702_13939988')) {function content_590b8784789702_13939988($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['admin_edit']->value) {?>


<?php $_smarty_tpl->tpl_vars["list_edit"] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/".((string)$_smarty_tpl->tpl_vars['admin_section']->value)."/edit_".((string)$_smarty_tpl->tpl_vars['admin_table']->value).".tpl", null, 0);?>

<?php if (file_exists($_smarty_tpl->tpl_vars['list_edit']->value)) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['list_edit']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/custom/edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
    
    

<?php } else { ?>


<?php $_smarty_tpl->tpl_vars["list_custom"] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/".((string)$_smarty_tpl->tpl_vars['admin_section']->value)."/list_".((string)$_smarty_tpl->tpl_vars['admin_table']->value).".tpl", null, 0);?>

<?php if (file_exists($_smarty_tpl->tpl_vars['list_custom']->value)) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['list_custom']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/custom/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
	


<?php }?>

<?php }} ?>
