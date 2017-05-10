<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/widget/menu-user.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb76e046_14763483',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '196a30b80994bb8a6cdf3a386eeffe08d2e0fc2b' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/menu-user.tpl',
      1 => 1493653671,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb76e046_14763483 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="text-right">

<?php if ($_smarty_tpl->tpl_vars['user']->value['id']) {?>


<div class="dropdown">
  <p class="dropdown-toggle" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Hello, 
    <b><?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</b>&nbsp;<span class="caret"></span>
  </p>
  <ul class="dropdown-menu" aria-labelledby="dropdownUser">
  
<?php $_smarty_tpl->_assignInScope('items', $_smarty_tpl->tpl_vars['menu']->value['user']);
?>

  
<?php
$__section_index_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index'] : false;
$__section_index_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['items']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_0_total = $__section_index_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_0_total != 0) {
for ($__section_index_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_0_iteration <= $__section_index_0_total; $__section_index_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
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
if ($__section_index_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_index'] = $__section_index_0_saved;
}
?>

  </ul>
</div>

</div>

<?php } else { ?>


<?php $_smarty_tpl->_assignInScope('items', $_smarty_tpl->tpl_vars['menu']->value['nouser']);
?>

<ul class="list-unstyled">
<?php
$__section_index_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index'] : false;
$__section_index_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['items']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_1_total = $__section_index_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_1_total != 0) {
for ($__section_index_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_1_iteration <= $__section_index_1_total; $__section_index_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
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
if ($__section_index_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_index'] = $__section_index_1_saved;
}
?>
</ul>


</div>

<?php }
}
}
