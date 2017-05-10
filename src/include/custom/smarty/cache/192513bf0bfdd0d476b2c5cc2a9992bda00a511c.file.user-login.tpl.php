<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:46:52
         compiled from "/Users/max/sitograph/src/templates/default/user-login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17694724590b852cc56995-25778015%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '192513bf0bfdd0d476b2c5cc2a9992bda00a511c' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/user-login.tpl',
      1 => 1493653818,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17694724590b852cc56995-25778015',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'document' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b852cc7e4c5_06039914',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b852cc7e4c5_06039914')) {function content_590b852cc7e4c5_06039914($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container top-menu">
	<div class="row">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container">
	<div class="row content-block">
	
    <div class="col-md-6 col-md-offset-3">
    	<?php if ($_smarty_tpl->tpl_vars['document']->value['name']) {?>
	    <h1><?php echo $_smarty_tpl->tpl_vars['document']->value['name'];?>
</h1>
	    <?php }?>
	    
    	<?php if ($_smarty_tpl->tpl_vars['document']->value) {?>
    		<?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>
<br />
    	<?php }?>
    	
    	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/messages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    	
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/user/login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </div>
    
	</div>
</div>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
