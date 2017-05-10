<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:47
  from "/Users/max/sitograph/src/templates/default/sitograph/list-table.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c47c1fe20_37325885',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f0cb96df286a7cf7db9fcae5c26984430bebf39' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/list-table.tpl',
      1 => 1490460444,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c47c1fe20_37325885 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/Users/max/sitograph/src/include/custom/plugins/modifier.truncate.php';
if ($_smarty_tpl->tpl_vars['listTable']->value) {?>
<div class="table-responsive">
<table class="table table-hover table-striped table-module">

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['listTable']->value, 'item', false, 'item_id', 'loop', array (
  'first' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item_id']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['index'];
?>

<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['first'] : null)) {?>
<tr>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value, 'itemField', false, 'itemFieldID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['itemFieldID']->value => $_smarty_tpl->tpl_vars['itemField']->value) {
?> 
<?php if (!in_array($_smarty_tpl->tpl_vars['itemFieldID']->value,$_smarty_tpl->tpl_vars['admin_list_skip']->value) && !empty($_smarty_tpl->tpl_vars['admin_table_info']->value['fields'][$_smarty_tpl->tpl_vars['itemFieldID']->value]['type'])) {?>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value == $_smarty_tpl->tpl_vars['itemFieldID']->value) {?> class='colactive'<?php }?>>
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=<?php echo $_smarty_tpl->tpl_vars['itemFieldID']->value;?>
&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
&p=<?php echo $_smarty_tpl->tpl_vars['admin_list_page']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.".((string)$_smarty_tpl->tpl_vars['admin_table']->value).".".((string)$_smarty_tpl->tpl_vars['itemFieldID']->value)];?>
</a><?php if ($_smarty_tpl->tpl_vars['table_sort']->value == $_smarty_tpl->tpl_vars['itemFieldID']->value) {
if ($_smarty_tpl->tpl_vars['table_sortd']->value == "asc") {?>&darr;<?php } else { ?>&uarr;<?php }
}?>
</th>
<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

<th><?php echo $_smarty_tpl->tpl_vars['t']->value["actions"];?>
</th>
</tr>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['item']->value['published']) {?>
<tr>
<?php } else { ?>
<tr class="danger">
<?php }
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value, 'itemField', false, 'itemFieldID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['itemFieldID']->value => $_smarty_tpl->tpl_vars['itemField']->value) {
if (!in_array($_smarty_tpl->tpl_vars['itemFieldID']->value,$_smarty_tpl->tpl_vars['admin_list_skip']->value) && !empty($_smarty_tpl->tpl_vars['admin_table_info']->value['fields'][$_smarty_tpl->tpl_vars['itemFieldID']->value]['type'])) {
$_smarty_tpl->_assignInScope('type', $_smarty_tpl->tpl_vars['admin_table_info']->value['fields'][$_smarty_tpl->tpl_vars['itemFieldID']->value]['type']);
if ($_smarty_tpl->tpl_vars['type']->value === "pic") {?>
<td>
<?php if ($_smarty_tpl->tpl_vars['itemField']->value) {?>
	<img src="<?php echo $_smarty_tpl->tpl_vars['itemField']->value;?>
" class="img-responsive" style="max-height:100px;">
<?php }?>
</td>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value === "updated" || $_smarty_tpl->tpl_vars['type']->value === "date") {?>
<td><small><?php echo $_smarty_tpl->tpl_vars['itemField']->value;?>
</small></td>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value === "bool") {?>
<td>
<?php if ($_smarty_tpl->tpl_vars['itemField']->value) {?>
<span class="text-success"><?php echo $_smarty_tpl->tpl_vars['t']->value["yes"];?>
</span>
<?php } else { ?>
<span class="text-danger"><?php echo $_smarty_tpl->tpl_vars['t']->value["no"];?>
</span>
<?php }?>
</td>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value === "doc") {?>
<td><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['itemField']->value),300,"..");?>
</td>
<?php } else { ?>
<td><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['itemField']->value),60,"..");?>
</td>
<?php }
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


<td class="text-nowrap">
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&edit=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&p=<?php echo $_smarty_tpl->tpl_vars['admin_list_page']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['t']->value['btn.edit'];?>
" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&duplicate=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&p=<?php echo $_smarty_tpl->tpl_vars['admin_list_page']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['t']->value['btn.duplicate'];?>
" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-duplicate"></span></a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&delete=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&p=<?php echo $_smarty_tpl->tpl_vars['admin_list_page']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['t']->value['btn.delete'];?>
" class="btn btn-danger btn-sm" onclick="if (!confirm('<?php echo $_smarty_tpl->tpl_vars['t']->value["btn.remove_confirm"];?>
')) return false;"><span class="glyphicon glyphicon-remove"></span></a>
</td>


</tr>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</div>
</table>


<?php if ($_smarty_tpl->tpl_vars['admin_list_pages']->value) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('pagination'=>$_smarty_tpl->tpl_vars['admin_list_pages']->value,'urlsuffix'=>"&section=".((string)$_smarty_tpl->tpl_vars['admin_section']->value)."&table=".((string)$_smarty_tpl->tpl_vars['admin_table']->value)."&sort=".((string)$_smarty_tpl->tpl_vars['table_sort']->value)."&sortd=".((string)$_smarty_tpl->tpl_vars['table_sortd']->value)), 0, true);
?>

<?php }?>



<?php } else { ?>

<div class="col-sm-6 col-md-offset-2">
<div class="alert alert-info"><?php echo _t("not_found");?>
</div>
</div>

<?php }?> 

<div class="col-sm-6">
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&add_new" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span><?php echo $_smarty_tpl->tpl_vars['t']->value["btn.add_new"];?>
</a>
</div>

<div class="col-sm-6 text-right">
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&export" class="btn btn-info"><span class="glyphicon glyphicon-download">&nbsp;</span><?php echo _t("btn.export_table");?>
</a>
</div><?php }
}
