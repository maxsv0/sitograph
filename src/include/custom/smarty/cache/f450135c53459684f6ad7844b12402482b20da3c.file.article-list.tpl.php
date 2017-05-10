<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/blog/article-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:861969542590b5edf54d6f8-74962736%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f450135c53459684f6ad7844b12402482b20da3c' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/blog/article-list.tpl',
      1 => 1492250622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '861969542590b5edf54d6f8-74962736',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'article' => 0,
    'lang_url' => 0,
    'blog' => 0,
    'category' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edf569bb8_35496096',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edf569bb8_35496096')) {function content_590b5edf569bb8_35496096($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/Users/max/sitograph/src/include/custom/smarty/plugins/function.math.php';
?><?php if ($_smarty_tpl->tpl_vars['article']->value['sections']) {?>
<div class="category-block">
<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['article']->value['sections']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['category']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['category']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['category']->iteration++;
 $_smarty_tpl->tpl_vars['category']->last = $_smarty_tpl->tpl_vars['category']->iteration === $_smarty_tpl->tpl_vars['category']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['last'] = $_smarty_tpl->tpl_vars['category']->last;
?> 
<h4><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/blog/?<?php echo $_smarty_tpl->tpl_vars['blog']->value['categoryUrlParam'];?>
=<?php echo $_smarty_tpl->tpl_vars['category']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value['title'];?>
</a></h4>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['last']) {?> / <?php }?>
<?php } ?>
</div>
<?php }?>


<div class="articles-block">

<h2><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/"><?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a></h2>

<div class="row article-info-block">
	<div class="col-sm-6 text-muted small">
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/blog/?<?php echo $_smarty_tpl->tpl_vars['blog']->value['authorUrlParam'];?>
=<?php echo $_smarty_tpl->tpl_vars['article']->value['author'];?>
"><?php echo $_smarty_tpl->tpl_vars['article']->value['author'];?>
</a> 
	posted on <?php echo $_smarty_tpl->tpl_vars['article']->value['date'];?>

	</div>
	
	<div class="col-sm-6 text-right small">
	<?php echo $_smarty_tpl->tpl_vars['article']->value['shares'];?>
 Shares 
	&nbsp;&nbsp;&nbsp;
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
<?php if ($_smarty_tpl->tpl_vars['article']->value['views']<4000) {?>
	<?php echo $_smarty_tpl->tpl_vars['article']->value['views'];?>

<?php } else { ?>
	<?php echo smarty_function_math(array('equation'=>"x / 1000",'x'=>$_smarty_tpl->tpl_vars['article']->value['views'],'format'=>"%.2f"),$_smarty_tpl);?>
K
<?php }?>
	Views
	&nbsp;&nbsp;&nbsp;
	<span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <?php echo $_smarty_tpl->tpl_vars['article']->value['comments'];?>

	</div>
</div>


<?php if ($_smarty_tpl->tpl_vars['article']->value['pic_preview']) {?>
<div class="article-media-block">
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/">
<img src="<?php echo $_smarty_tpl->tpl_vars['article']->value['pic_preview'];?>
" alt="" class="thumbnail img-responsive"/>
</a>
</div>
<?php }?>

<div class="article-description-block">
<?php if ($_smarty_tpl->tpl_vars['article']->value['description']) {?>
	<?php echo $_smarty_tpl->tpl_vars['article']->value['description'];?>

<?php }?>
</div>

<div class="article-more-block">
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/" class="btn btn-primary"><?php echo _t("blog.continue_reading");?>
</a>
</div>



</div> <?php }} ?>
