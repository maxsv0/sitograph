<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/widget/menu-bottom.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb7fdbd7_84603265',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ef1b09207207f90eb3afe4784e75aee45111df75' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/menu-bottom.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb7fdbd7_84603265 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('items', $_smarty_tpl->tpl_vars['menu']->value['bottom']);
?>

<ul class="list-inline">
<?php
$__section_index_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index'] : false;
$__section_index_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['items']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_3_total = $__section_index_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_3_total != 0) {
for ($__section_index_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_3_iteration <= $__section_index_3_total; $__section_index_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
?> 

<?php if ($_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'] == $_smarty_tpl->tpl_vars['page']->value['url']) {?>
    <li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['name'];?>
</a></li>
<?php } else { ?>
    <li><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['name'];?>
</a></li>
<?php }?>

<?php
}
}
if ($__section_index_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_index'] = $__section_index_3_saved;
}
?>
</ul>
<?php }
}
