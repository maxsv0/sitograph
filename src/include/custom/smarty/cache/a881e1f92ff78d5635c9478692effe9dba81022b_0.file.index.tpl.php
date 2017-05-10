<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb6cc4e9_07199261',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a881e1f92ff78d5635c9478692effe9dba81022b' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/index.tpl',
      1 => 1492446545,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb6cc4e9_07199261 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


<div class="container top-menu">
	<div class="row">
		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	</div>
</div>

<div class="container content-block">
	<div class="row">
	
	<?php if ($_smarty_tpl->tpl_vars['document']->value['name']) {?>
	<div class="col-lg-12 title_block"><h1><?php echo $_smarty_tpl->tpl_vars['document']->value['name'];?>
</h1></div>
	<?php }?>
	
	<div class="col-lg-8 col-md-7 col-sm-12">
	<?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>

	</div>
	
	<div class="col-lg-8 col-md-7 col-sm-12">

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['blog_articles_newest']->value, 'article', false, 'article_id');
$_smarty_tpl->tpl_vars['article']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['article_id']->value => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->iteration++;
$__foreach_article_0_saved = $_smarty_tpl->tpl_vars['article'];
?> 
<?php if ($_smarty_tpl->tpl_vars['article']->iteration <= 2) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/article-preview.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
$_smarty_tpl->tpl_vars['article'] = $__foreach_article_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	</div>
	

	<div class="col-lg-4 col-md-5 hidden-sm">
	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	</div>
	
	</div><!-- row -->
	

	<div class="row">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['blog_articles_newest']->value, 'article', false, 'article_id');
$_smarty_tpl->tpl_vars['article']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['article_id']->value => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->iteration++;
$__foreach_article_1_saved = $_smarty_tpl->tpl_vars['article'];
?> 
<?php if ($_smarty_tpl->tpl_vars['article']->iteration > 2) {?>
<div class="col-lg-3 col-md-4 col-sm-6">
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/article-preview-short.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

</div>
<?php }
$_smarty_tpl->tpl_vars['article'] = $__foreach_article_1_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	

	</div><!-- row -->
</div>




<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
