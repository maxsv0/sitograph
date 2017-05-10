<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/widget/menu-bottom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:811157231590b5edcb08157-23258700%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e8d655147b7c8ed7f4cc6f1f2f0fed2a32baa4f' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/menu-bottom.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '811157231590b5edcb08157-23258700',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'items' => 0,
    'page' => 0,
    'lang_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edcb137f3_09313640',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edcb137f3_09313640')) {function content_590b5edcb137f3_09313640($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars["items"] = new Smarty_variable($_smarty_tpl->tpl_vars['menu']->value['bottom'], null, 0);?>

<ul class="list-inline">
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['index'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['index']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['name'] = 'index';
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['items']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total']);
?> 

<?php if ($_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url']==$_smarty_tpl->tpl_vars['page']->value['url']) {?>
    <li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['name'];?>
</a></li>
<?php } else { ?>
    <li><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['name'];?>
</a></li>
<?php }?>

<?php endfor; endif; ?>
</ul>
<?php }} ?>
