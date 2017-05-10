<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:51:41
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/section/site_settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1570208543590b864d8d1894-26743327%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83536ba2104b0aa4eacfee75f7e95cf354303ab2' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/section/site_settings.tpl',
      1 => 1489421238,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1570208543590b864d8d1894-26743327',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_edit' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b864d8f3411_59649294',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b864d8f3411_59649294')) {function content_590b864d8f3411_59649294($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['admin_edit']->value) {?>


    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/site_settings/edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<?php } else { ?>


	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/site_settings/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<?php }?>



<?php }} ?>
