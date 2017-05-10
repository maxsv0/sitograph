<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:56:48
         compiled from "/Users/max/sitograph/src/templates/default/user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:218026964590b8780cdb597-62292515%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1e60c0b72aaf43be3053d131c0711412f4a3ba1' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/user.tpl',
      1 => 1493650145,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '218026964590b8780cdb597-62292515',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
    'document' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b8780d0b7a0_92230238',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b8780d0b7a0_92230238')) {function content_590b8780d0b7a0_92230238($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container top-menu">
	<div class="row">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container">
	<div class="row content-block">

    <?php if ($_smarty_tpl->tpl_vars['page']->value['name']) {?>
    <div class="col-lg-12"><h1><?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
</h1></div>
    <?php }?>
    
    <div class="col-lg-8 col-md-7 col-sm-12">
    	<?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>

        <?php if ($_smarty_tpl->tpl_vars['user']->value['id']) {?>
        	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/user/homepage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php } else { ?>
        	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/user/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php }?> 
    </div>
    <div class="col-lg-4 col-md-5 hidden-sm">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </div>
	</div>
</div>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
