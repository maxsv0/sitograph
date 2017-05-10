<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:04
  from "/Users/max/sitograph/src/templates/default/blog/list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c1c2fa043_37311302',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fffbd7ab7638bafb6a3c8292888dbdd8b6f37eff' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/blog/list.tpl',
      1 => 1493645151,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c1c2fa043_37311302 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['blog_articles']->value, 'article', false, 'article_id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['article_id']->value => $_smarty_tpl->tpl_vars['article']->value) {
?> 

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/article-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


<?php
}
} else {
?>


<div class="alert alert-info"><?php echo _t('blog.search_no_result');?>
</div>

<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 
        
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('pagination'=>$_smarty_tpl->tpl_vars['blog_pages']->value), 0, true);
?>

<?php }
}
