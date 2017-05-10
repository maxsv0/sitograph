<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/widget/sideblock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1049827106590b5edcae3365-98144431%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '993d5a3e04817641b585e3b7db98c244a3e437bd' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/sideblock.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1049827106590b5edcae3365-98144431',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edcae6fd2_96977387',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edcae6fd2_96977387')) {function content_590b5edcae6fd2_96977387($_smarty_tpl) {?><p class="text-center">
<img src="http://placehold.it/320x280">
<small class="text-muted">advertisment</small>
</p>


<p>&nbsp;</p>

<?php if (file_exists(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock-blog.tpl")) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/sideblock-blog.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php }} ?>
