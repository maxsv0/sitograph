<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:26
         compiled from "/Users/max/sitograph/src/templates/default/widget/navigation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1047763379590b5ede7fb310-27839328%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e45978af482206cbd0dc9c61d7003a535310fdf' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/navigation.tpl',
      1 => 1492201544,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1047763379590b5ede7fb310-27839328',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'navigation' => 0,
    'lang_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5ede817583_85797562',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5ede817583_85797562')) {function content_590b5ede817583_85797562($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['navigation']->value) {?>
<div class="container navigation">
    <ul class="bread_block block-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['index'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['index']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['name'] = 'index';
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['navigation']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
        <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['index']['last']) {?>
        <li class="current-crumbs"><span><?php echo $_smarty_tpl->tpl_vars['navigation']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['name'];?>
</span></li>
        <?php } else { ?>
        <li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['navigation']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['navigation']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['name'];?>
</a></li> 
         <li>&nbsp;>&nbsp;</li>
        <?php }?>
    <?php endfor; endif; ?>   
	</ul> 
</div>
<?php }?><?php }} ?>
