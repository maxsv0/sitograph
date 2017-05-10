<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:51:41
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/list-table.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2133480315590b864d8fad58-46022011%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa0ad10565d1f23b1400a1cbf9c343eb02d59919' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/list-table.tpl',
      1 => 1490460444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2133480315590b864d8fad58-46022011',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'listTable' => 0,
    'item' => 0,
    'itemFieldID' => 0,
    'admin_list_skip' => 0,
    'admin_table_info' => 0,
    'table_sort' => 0,
    'lang_url' => 0,
    'admin_section' => 0,
    'admin_table' => 0,
    'table_sortd_rev' => 0,
    'admin_list_page' => 0,
    't' => 0,
    'table_sortd' => 0,
    'type' => 0,
    'itemField' => 0,
    'admin_list_pages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b864d9363c9_51977162',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b864d9363c9_51977162')) {function content_590b864d9363c9_51977162($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/Users/max/sitograph/src/include/custom/smarty/plugins/modifier.truncate.php';
?><?php if ($_smarty_tpl->tpl_vars['listTable']->value) {?>
<div class="table-responsive">
<table class="table table-hover table-striped table-module">

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['item_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['listTable']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item_id']->value = $_smarty_tpl->tpl_vars['item']->key;
 $_smarty_tpl->tpl_vars['item']->index++;
 $_smarty_tpl->tpl_vars['item']->first = $_smarty_tpl->tpl_vars['item']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['first'] = $_smarty_tpl->tpl_vars['item']->first;
?>

<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['first']) {?>
<tr>
<?php  $_smarty_tpl->tpl_vars['itemField'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemField']->_loop = false;
 $_smarty_tpl->tpl_vars['itemFieldID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemField']->key => $_smarty_tpl->tpl_vars['itemField']->value) {
$_smarty_tpl->tpl_vars['itemField']->_loop = true;
 $_smarty_tpl->tpl_vars['itemFieldID']->value = $_smarty_tpl->tpl_vars['itemField']->key;
?> 
<?php if (!in_array($_smarty_tpl->tpl_vars['itemFieldID']->value,$_smarty_tpl->tpl_vars['admin_list_skip']->value)&&!empty($_smarty_tpl->tpl_vars['admin_table_info']->value['fields'][$_smarty_tpl->tpl_vars['itemFieldID']->value]['type'])) {?>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value==$_smarty_tpl->tpl_vars['itemFieldID']->value) {?> class='colactive'<?php }?>>
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=<?php echo $_smarty_tpl->tpl_vars['itemFieldID']->value;?>
&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
&p=<?php echo $_smarty_tpl->tpl_vars['admin_list_page']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.".((string)$_smarty_tpl->tpl_vars['admin_table']->value).".".((string)$_smarty_tpl->tpl_vars['itemFieldID']->value)];?>
</a><?php if ($_smarty_tpl->tpl_vars['table_sort']->value==$_smarty_tpl->tpl_vars['itemFieldID']->value) {?><?php if ($_smarty_tpl->tpl_vars['table_sortd']->value=="asc") {?>&darr;<?php } else { ?>&uarr;<?php }?><?php }?>
</th>
<?php }?>
<?php } ?>
<th><?php echo $_smarty_tpl->tpl_vars['t']->value["actions"];?>
</th>
</tr>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['item']->value['published']) {?>
<tr>
<?php } else { ?>
<tr class="danger">
<?php }?>
<?php  $_smarty_tpl->tpl_vars['itemField'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemField']->_loop = false;
 $_smarty_tpl->tpl_vars['itemFieldID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemField']->key => $_smarty_tpl->tpl_vars['itemField']->value) {
$_smarty_tpl->tpl_vars['itemField']->_loop = true;
 $_smarty_tpl->tpl_vars['itemFieldID']->value = $_smarty_tpl->tpl_vars['itemField']->key;
?>
<?php if (!in_array($_smarty_tpl->tpl_vars['itemFieldID']->value,$_smarty_tpl->tpl_vars['admin_list_skip']->value)&&!empty($_smarty_tpl->tpl_vars['admin_table_info']->value['fields'][$_smarty_tpl->tpl_vars['itemFieldID']->value]['type'])) {?>
<?php $_smarty_tpl->tpl_vars["type"] = new Smarty_variable($_smarty_tpl->tpl_vars['admin_table_info']->value['fields'][$_smarty_tpl->tpl_vars['itemFieldID']->value]['type'], null, 0);?>
<?php if ($_smarty_tpl->tpl_vars['type']->value==="pic") {?>
<td>
<?php if ($_smarty_tpl->tpl_vars['itemField']->value) {?>
	<img src="<?php echo $_smarty_tpl->tpl_vars['itemField']->value;?>
" class="img-responsive" style="max-height:100px;">
<?php }?>
</td>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value==="updated"||$_smarty_tpl->tpl_vars['type']->value==="date") {?>
<td><small><?php echo $_smarty_tpl->tpl_vars['itemField']->value;?>
</small></td>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value==="bool") {?>
<td>
<?php if ($_smarty_tpl->tpl_vars['itemField']->value) {?>
<span class="text-success"><?php echo $_smarty_tpl->tpl_vars['t']->value["yes"];?>
</span>
<?php } else { ?>
<span class="text-danger"><?php echo $_smarty_tpl->tpl_vars['t']->value["no"];?>
</span>
<?php }?>
</td>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value==="doc") {?>
<td><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['itemField']->value),300,"..");?>
</td>
<?php } else { ?>
<td><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['itemField']->value),60,"..");?>
</td>
<?php }?>
<?php }?>
<?php } ?>

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
<?php } ?>
</div>
</table>


<?php if ($_smarty_tpl->tpl_vars['admin_list_pages']->value) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('pagination'=>$_smarty_tpl->tpl_vars['admin_list_pages']->value,'urlsuffix'=>"&section=".((string)$_smarty_tpl->tpl_vars['admin_section']->value)."&table=".((string)$_smarty_tpl->tpl_vars['admin_table']->value)."&sort=".((string)$_smarty_tpl->tpl_vars['table_sort']->value)."&sortd=".((string)$_smarty_tpl->tpl_vars['table_sortd']->value)), 0);?>

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
</div><?php }} ?>
