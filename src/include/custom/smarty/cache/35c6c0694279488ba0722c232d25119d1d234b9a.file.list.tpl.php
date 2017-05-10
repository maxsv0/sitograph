<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/blog/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:72539768590b5edf542684-05868132%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35c6c0694279488ba0722c232d25119d1d234b9a' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/blog/list.tpl',
      1 => 1493645151,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72539768590b5edf542684-05868132',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blog_articles' => 0,
    'blog_pages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edf54ace6_91521340',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edf54ace6_91521340')) {function content_590b5edf54ace6_91521340($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_smarty_tpl->tpl_vars['article_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['blog_articles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
 $_smarty_tpl->tpl_vars['article_id']->value = $_smarty_tpl->tpl_vars['article']->key;
?> 

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/article-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php }
if (!$_smarty_tpl->tpl_vars['article']->_loop) {
?>

<div class="alert alert-info"><?php echo _t('blog.search_no_result');?>
</div>

<?php } ?> 
        
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('pagination'=>$_smarty_tpl->tpl_vars['blog_pages']->value), 0);?>

<?php }} ?>
