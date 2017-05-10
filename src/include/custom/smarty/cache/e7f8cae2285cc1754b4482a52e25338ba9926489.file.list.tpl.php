<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:56:52
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/custom/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:879080601590b878478ddd5-36346287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e7f8cae2285cc1754b4482a52e25338ba9926489' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/custom/list.tpl',
      1 => 1489421139,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '879080601590b878478ddd5-36346287',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b8784791129_57558708',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b8784791129_57558708')) {function content_590b8784791129_57558708($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/list-table.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('listTable'=>$_smarty_tpl->tpl_vars['admin_list']->value), 0);?>


<?php }} ?>
