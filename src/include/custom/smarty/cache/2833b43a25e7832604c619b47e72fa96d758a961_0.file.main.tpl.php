<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:03
  from "/Users/max/sitograph/src/templates/default/main.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c1bb16b23_83894218',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2833b43a25e7832604c619b47e72fa96d758a961' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/main.tpl',
      1 => 1493668652,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c1bb16b23_83894218 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


<div class="container top-menu">
	<div class="row">
		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	</div>
</div>

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


<div class="container">
	<div class="row content-block">

	<?php if ($_smarty_tpl->tpl_vars['document']->value['name']) {?>
	<div class="col-lg-12"><h1><?php echo $_smarty_tpl->tpl_vars['document']->value['name'];?>
</h1></div>
	<?php }?>
	
	<div class="col-lg-8 col-md-7 col-sm-12">
		<?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>

	</div>
	<div class="col-lg-4 col-md-5 hidden-sm">
		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	</div>
</div>
</div>
 

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
