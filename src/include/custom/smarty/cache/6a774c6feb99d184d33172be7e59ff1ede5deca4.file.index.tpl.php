<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1345554880590b5edca08ea1-79270552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a774c6feb99d184d33172be7e59ff1ede5deca4' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/index.tpl',
      1 => 1492446545,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1345554880590b5edca08ea1-79270552',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'document' => 0,
    'blog_articles_newest' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edca6fcf9_19941010',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edca6fcf9_19941010')) {function content_590b5edca6fcf9_19941010($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container top-menu">
	<div class="row">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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

<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_smarty_tpl->tpl_vars['article_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['blog_articles_newest']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['article']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
 $_smarty_tpl->tpl_vars['article_id']->value = $_smarty_tpl->tpl_vars['article']->key;
 $_smarty_tpl->tpl_vars['article']->iteration++;
?> 
<?php if ($_smarty_tpl->tpl_vars['article']->iteration<=2) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/article-preview.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php } ?>
	</div>
	

	<div class="col-lg-4 col-md-5 hidden-sm">
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
	
	</div><!-- row -->
	

	<div class="row">
<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_smarty_tpl->tpl_vars['article_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['blog_articles_newest']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['article']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
 $_smarty_tpl->tpl_vars['article_id']->value = $_smarty_tpl->tpl_vars['article']->key;
 $_smarty_tpl->tpl_vars['article']->iteration++;
?> 
<?php if ($_smarty_tpl->tpl_vars['article']->iteration>2) {?>
<div class="col-lg-3 col-md-4 col-sm-6">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/article-preview-short.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
<?php }?>
<?php } ?>
	

	</div><!-- row -->
</div>




<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
