<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:34
  from "/Users/max/sitograph/src/templates/default/gallery/main.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfe3dc123_58181659',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '63e435345283c1cbad33754879c6954ed7941095' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/gallery/main.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfe3dc123_58181659 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['gallery_album_details']->value) {?>

   <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/gallery/details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
 
     
<?php } else { ?>

   <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/gallery/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

   
<?php }
}
}
