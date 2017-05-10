<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/widget/sideblock-blog.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb7d63f5_86531722',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7d98adf5b7194a868ce6d50fc880e6991decac7d' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/sideblock-blog.tpl',
      1 => 1492351765,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb7d63f5_86531722 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="sideblock_search">
<form role="form" action="/blog/">
  <div class="form-group">
	<label for="inputSearch" class="control-label"><?php echo _t("blog.label_search");?>
</label>
	<input type="text" id="inputSearch" name="<?php echo $_smarty_tpl->tpl_vars['blog']->value['searchUrlParam'];?>
" class="search-input"/>
  </div>
  <input type="submit" class="send-btn" value="<?php echo _t("blog.btn_search");?>
"/>
</form>
</div>
<br />


<h3><?php echo _t("blog.label_рopular_posts");?>
</h3>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['blog_articles_topviews']->value, 'article', false, 'article_id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['article_id']->value => $_smarty_tpl->tpl_vars['article']->value) {
?> 

<div class="media">
<?php if ($_smarty_tpl->tpl_vars['article']->value['pic_preview']) {?>
  <div class="media-left">
    <a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/">
      <img class="media-object" src="<?php echo $_smarty_tpl->tpl_vars['article']->value['pic_preview'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
" width="64">
    </a>
  </div>
<?php }?>
  <div class="media-body">
    <a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/"><?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a>
  </div>
</div>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 <?php }
}
