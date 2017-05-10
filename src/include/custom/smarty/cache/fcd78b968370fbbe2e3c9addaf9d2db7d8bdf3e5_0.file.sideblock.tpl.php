<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/widget/sideblock.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb7aabd7_49155649',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fcd78b968370fbbe2e3c9addaf9d2db7d8bdf3e5' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/sideblock.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb7aabd7_49155649 (Smarty_Internal_Template $_smarty_tpl) {
?>
<p class="text-center">
<img src="http://placehold.it/320x280">
<small class="text-muted">advertisment</small>
</p>


<p>&nbsp;</p>

<?php if (file_exists(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock-blog.tpl")) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock-blog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
}
