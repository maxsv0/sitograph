<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:51:41
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/site_settings/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:152700503590b864d8f5de9-33975456%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1fe1332836b1e5b9c426c4919e8120a7f866acd' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/site_settings/list.tpl',
      1 => 1489848224,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152700503590b864d8f5de9-33975456',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b864d8f8dd4_08353412',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b864d8f8dd4_08353412')) {function content_590b864d8f8dd4_08353412($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/list-table.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('listTable'=>$_smarty_tpl->tpl_vars['admin_list']->value), 0);?>


<?php }} ?>
