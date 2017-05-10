<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/widget/sideblock-blog.tpl" */ ?>
<?php /*%%SmartyHeaderCode:651612818590b5edcae9149-92823168%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09e2249703697fba73f1d27c559357dd8ec402a8' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/sideblock-blog.tpl',
      1 => 1492351765,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '651612818590b5edcae9149-92823168',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blog' => 0,
    'blog_articles_topviews' => 0,
    'article' => 0,
    'lang_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edcaf3c49_81510454',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edcaf3c49_81510454')) {function content_590b5edcaf3c49_81510454($_smarty_tpl) {?><div class="sideblock_search">
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

<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_smarty_tpl->tpl_vars['article_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['blog_articles_topviews']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
 $_smarty_tpl->tpl_vars['article_id']->value = $_smarty_tpl->tpl_vars['article']->key;
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

<?php } ?> <?php }} ?>
