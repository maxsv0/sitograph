<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:47
  from "/Users/max/sitograph/src/templates/default/sitograph/section/custom.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c47bbc4f6_32463285',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98de0a4ced2bab23b0c77cc31af05269810a72c6' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/section/custom.tpl',
      1 => 1489421161,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c47bbc4f6_32463285 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['admin_edit']->value) {?>


<?php $_smarty_tpl->_assignInScope('list_edit', ((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/".((string)$_smarty_tpl->tpl_vars['admin_section']->value)."/edit_".((string)$_smarty_tpl->tpl_vars['admin_table']->value).".tpl");
?>

<?php if (file_exists($_smarty_tpl->tpl_vars['list_edit']->value)) {?>
	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['list_edit']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php } else { ?>
	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/custom/edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }?>
    
    

<?php } else { ?>


<?php $_smarty_tpl->_assignInScope('list_custom', ((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/".((string)$_smarty_tpl->tpl_vars['admin_section']->value)."/list_".((string)$_smarty_tpl->tpl_vars['admin_table']->value).".tpl");
?>

<?php if (file_exists($_smarty_tpl->tpl_vars['list_custom']->value)) {?>
	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['list_custom']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php } else { ?>
	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/custom/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }?>
	


<?php }?>

<?php }
}
