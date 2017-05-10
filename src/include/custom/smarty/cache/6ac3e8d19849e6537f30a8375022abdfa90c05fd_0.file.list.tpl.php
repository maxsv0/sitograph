<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:47
  from "/Users/max/sitograph/src/templates/default/sitograph/custom/list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c47bc84a1_00273367',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ac3e8d19849e6537f30a8375022abdfa90c05fd' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/custom/list.tpl',
      1 => 1489421139,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c47bc84a1_00273367 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/list-table.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('listTable'=>$_smarty_tpl->tpl_vars['admin_list']->value), 0, true);
?>


<?php }
}
