<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/blog/article-preview-short.tpl" */ ?>
<?php /*%%SmartyHeaderCode:588738570590b5edcaf69a2-15672799%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e55ce40d6bbe1237df6f721ee2e85b001e079ed' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/blog/article-preview-short.tpl',
      1 => 1493645653,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '588738570590b5edcaf69a2-15672799',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'article' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edcafe793_63440413',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edcafe793_63440413')) {function content_590b5edcafe793_63440413($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['article']->value['pic_preview']) {?>
<div class="article-media-block">
<a href="/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/" title="<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
">
<img src="<?php echo $_smarty_tpl->tpl_vars['article']->value['pic_preview'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
" class="thumbnail img-responsive">
</a>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['article']->value['description']) {?>
<div class="caption">
	<p><?php echo $_smarty_tpl->tpl_vars['article']->value['description'];?>
</p>
</div>
<?php }?>


<div class="article-title-block">
<h4><a href="/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/"><?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a></h4>
</div>
<?php }} ?>
