<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:04
  from "/Users/max/sitograph/src/templates/default/blog/main.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c1c2e97c1_73601423',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a9b28a67c2f8164fc5245811c6141a68cb1ea44c' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/blog/main.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c1c2e97c1_73601423 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['blog_article_details']->value) {?>
    
	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	 
<?php } else { ?>

   <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

   
<?php }?> <?php }
}
