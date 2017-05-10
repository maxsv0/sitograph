<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/blog/article-preview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1335878982590b5edcac8dd8-20230301%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4531543872bfe7f1a359527b6d16fb59aee09744' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/blog/article-preview.tpl',
      1 => 1493645654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1335878982590b5edcac8dd8-20230301',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'article' => 0,
    'lang_url' => 0,
    'blog' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edcae0266_94002576',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edcae0266_94002576')) {function content_590b5edcae0266_94002576($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/Users/max/sitograph/src/include/custom/smarty/plugins/function.math.php';
?>
<div class="article-title-block">
<h2><a href="/blog/<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
/"><?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a></h2>
</div>


<div class="article-info-block">
	<div class="row">
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
</div>


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
<?php }?>


<?php if ($_smarty_tpl->tpl_vars['article']->value['description']) {?>
	<p><?php echo $_smarty_tpl->tpl_vars['article']->value['description'];?>
</p>
<?php }?>
<?php }} ?>
