<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/main-blog.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1699696751590b5edf4e1140-58788229%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b31d2aee75a08fc3f568b630a1c7a62cce9f95d' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/main-blog.tpl',
      1 => 1493645359,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1699696751590b5edf4e1140-58788229',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blog_article_details' => 0,
    'page' => 0,
    'document' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edf514180_09509168',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edf514180_09509168')) {function content_590b5edf514180_09509168($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container top-menu">
	<div class="row">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


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
    	<?php if ($_smarty_tpl->tpl_vars['document']->value) {?><?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>
<?php }?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </div>
    <div class="col-lg-4 col-md-5 hidden-sm">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </div>
	</div>
</div>
  

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
