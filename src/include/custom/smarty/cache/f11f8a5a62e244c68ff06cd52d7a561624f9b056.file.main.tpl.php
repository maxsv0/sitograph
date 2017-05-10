<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:26
         compiled from "/Users/max/sitograph/src/templates/default/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2139960738590b5ede7b32a8-29223727%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f11f8a5a62e244c68ff06cd52d7a561624f9b056' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/main.tpl',
      1 => 1493668652,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2139960738590b5ede7b32a8-29223727',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'document' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5ede7dc8d2_46540112',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5ede7dc8d2_46540112')) {function content_590b5ede7dc8d2_46540112($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container top-menu">
	<div class="row">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container">
	<div class="row content-block">

	<?php if ($_smarty_tpl->tpl_vars['document']->value['name']) {?>
	<div class="col-lg-12"><h1><?php echo $_smarty_tpl->tpl_vars['document']->value['name'];?>
</h1></div>
	<?php }?>
	
	<div class="col-lg-8 col-md-7 col-sm-12">
		<?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>

	</div>
	<div class="col-lg-4 col-md-5 hidden-sm">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div>
</div>
 

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
