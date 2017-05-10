<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:47:07
         compiled from "/Users/max/sitograph/src/templates/default/user-signup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:419785583590b853b6f5c23-30631854%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd145d5afb758e63c74e7ed8182adc9676c212383' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/user-signup.tpl',
      1 => 1493653785,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '419785583590b853b6f5c23-30631854',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'document' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b853b723086_77539017',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b853b723086_77539017')) {function content_590b853b723086_77539017($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container top-menu">
	<div class="row">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container">
	<div class="row content-block">

    <div class="col-md-8 col-md-offset-2">
    	<?php if ($_smarty_tpl->tpl_vars['document']->value['name']) {?>
	    <h1><?php echo $_smarty_tpl->tpl_vars['document']->value['name'];?>
</h1>
	    <?php }?>
	    
    	<?php if ($_smarty_tpl->tpl_vars['document']->value) {?>
    		<?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>
<br />
    	<?php }?>
    	
    	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/messages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    	
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/user/signup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </div>
    
	</div>
</div>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
