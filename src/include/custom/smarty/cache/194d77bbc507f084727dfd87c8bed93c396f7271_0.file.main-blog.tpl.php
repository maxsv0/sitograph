<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:04
  from "/Users/max/sitograph/src/templates/default/main-blog.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c1c2c85b3_56483904',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '194d77bbc507f084727dfd87c8bed93c396f7271' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/main-blog.tpl',
      1 => 1493645359,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c1c2c85b3_56483904 (Smarty_Internal_Template $_smarty_tpl) {
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
    <?php if ($_smarty_tpl->tpl_vars['blog_article_details']->value['title']) {?>
    <div class="col-lg-12 article-title-block"><h1><?php echo $_smarty_tpl->tpl_vars['blog_article_details']->value['title'];?>
</h1></div>
    <?php } elseif ($_smarty_tpl->tpl_vars['page']->value['name']) {?>
    <div class="col-lg-12 article-title-block"><h1><?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
</h1></div>
    <?php }?>
    
    <div class="col-lg-8 col-md-7 col-sm-12">
    	<?php if ($_smarty_tpl->tpl_vars['document']->value) {
echo $_smarty_tpl->tpl_vars['document']->value['text'];
}?>
        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

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
