<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:33:40
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/structure/list-level.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1365813937590b8214c97289-79559139%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f79db8004222d545e51b6d0c6283b06f3157143e' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/structure/list-level.tpl',
      1 => 1492183246,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1365813937590b8214c97289-79559139',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'show_parent_id' => 0,
    'listTable' => 0,
    'item' => 0,
    'level' => 0,
    'structure_show' => 0,
    't' => 0,
    'lang_url' => 0,
    'admin_section' => 0,
    'admin_table' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b8214cf3ff8_50632443',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b8214cf3ff8_50632443')) {function content_590b8214cf3ff8_50632443($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/Users/max/sitograph/src/include/custom/smarty/plugins/modifier.truncate.php';
?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['item_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['listTable']->value[$_smarty_tpl->tpl_vars['show_parent_id']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item_id']->value = $_smarty_tpl->tpl_vars['item']->key;
?>

<?php if ($_smarty_tpl->tpl_vars['show_parent_id']->value==0) {?>
<?php $_smarty_tpl->tpl_vars['level'] = new Smarty_variable(1, null, 0);?>    
<?php }?>
<tr <?php if ($_smarty_tpl->tpl_vars['item']->value['debug']) {?>class="danger"<?php }?> data-index="<?php echo $_smarty_tpl->tpl_vars['item']->value['parent_id'];?>
" data-level="<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['structure_show']->value&&$_smarty_tpl->tpl_vars['structure_show']->value[$_smarty_tpl->tpl_vars['item']->value['parent_id']]==$_smarty_tpl->tpl_vars['level']->value&&!empty($_smarty_tpl->tpl_vars['listTable']->value[$_smarty_tpl->tpl_vars['item']->value['id']])) {?>data-show="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" class="selected"<?php }?>>

<td>
<?php if (!empty($_smarty_tpl->tpl_vars['listTable']->value[$_smarty_tpl->tpl_vars['item']->value['id']])) {?>
<a href="javascript:void(0)" style="margin-top:3px" onclick="toogle_parent(this,'<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
')"><img id="block_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" src="/content/images/sitograph/arrow_right.png"/></a>
<?php }?>
</td>




<td class="text-nowrap">
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['index'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['index']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['name'] = 'index';
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] = (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['max']);
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
<span>»</span>&nbsp;
<?php endfor; endif; ?>
<span><?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['item']->value['name']),200,"..");?>
</span>
<?php if ($_smarty_tpl->tpl_vars['item']->value['debug']) {?>
<div><span class="badge">debug</span></div>
<?php }?>
</td>

<td class="text-nowrap">
<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
" target="_blank" style="text-decoration:none;"><?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
 <span class="glyphicon glyphicon-new-window"></span></a>
</td>

<td class="text-nowrap">
<small>
<?php if ($_smarty_tpl->tpl_vars['item']->value['template']) {?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['template']==="default") {?>
	<span class="text-muted"><?php echo $_smarty_tpl->tpl_vars['item']->value['template'];?>
</span>
<?php } else { ?>
	<span class="text-info"><?php echo $_smarty_tpl->tpl_vars['item']->value['template'];?>
</span>
<?php }?>
<?php } else { ?>
<span class="label label-danger"><?php echo _t("not_set");?>
</span>
<?php }?>

/

<?php if ($_smarty_tpl->tpl_vars['item']->value['page_template']) {?>
<?php echo $_smarty_tpl->tpl_vars['item']->value['page_template'];?>

<?php } else { ?>
<span class="label label-danger"><?php echo _t("not_set");?>
</span>
<?php }?>
</small>
</td>

<td class="text-nowrap text-center">
<?php if ($_smarty_tpl->tpl_vars['item']->value['access']==="everyone") {?>
	<span class="text-success"><?php echo $_smarty_tpl->tpl_vars['item']->value['access_data'];?>
</span>
<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['access']==="user") {?>
	<span class="text-warning"><?php echo $_smarty_tpl->tpl_vars['item']->value['access_data'];?>
</span>
<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['access']==="admin") {?>
	<span class="text-danger"><?php echo $_smarty_tpl->tpl_vars['item']->value['access_data'];?>
</span>
<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['access']==="superadmin") {?>
	<span class="text-danger"><b><?php echo $_smarty_tpl->tpl_vars['item']->value['access_data'];?>
</b></span>
<?php } else { ?>
	<?php echo $_smarty_tpl->tpl_vars['item']->value['access_data'];?>

<?php }?>
</td>
<td class="text-nowrap text-center">
<?php if ($_smarty_tpl->tpl_vars['item']->value['sitemap']) {?>
<span class="text-success"><?php echo $_smarty_tpl->tpl_vars['t']->value["yes"];?>
</span>
<?php } else { ?>
<span class="text-danger"><?php echo $_smarty_tpl->tpl_vars['t']->value["no"];?>
</span>
<?php }?>
</td>
<td class="text-nowrap text-center">
<?php if ($_smarty_tpl->tpl_vars['item']->value['published']) {?>
<span class="text-success"><?php echo $_smarty_tpl->tpl_vars['t']->value["yes"];?>
</span>
<?php } else { ?>
<span class="text-danger"><?php echo $_smarty_tpl->tpl_vars['t']->value["no"];?>
</span>
<?php }?>
</td>

<td><small><?php echo substr($_smarty_tpl->tpl_vars['item']->value['updated'],0,10);?>
</small></td>

<td class="text-nowrap">
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&edit=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['t']->value['btn.edit'];?>
" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&add_child=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['t']->value['btn.add_child'];?>
" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&duplicate=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['t']->value['btn.duplicate'];?>
" class="btn btn-warning"><span class="glyphicon glyphicon-duplicate"></span></a>
	<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&delete=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" onclick="if (!confirm('<?php echo $_smarty_tpl->tpl_vars['t']->value["btn.remove_confirm"];?>
')) return false;" title="<?php echo $_smarty_tpl->tpl_vars['t']->value['btn.delete'];?>
" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
</td>
</tr>


<?php if (!empty($_smarty_tpl->tpl_vars['listTable']->value[$_smarty_tpl->tpl_vars['item']->value['id']])) {?>
        <?php $_smarty_tpl->tpl_vars['level'] = new Smarty_variable($_smarty_tpl->tpl_vars['level']->value+1, null, 0);?>    
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/structure/list-level.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('listTable'=>$_smarty_tpl->tpl_vars['listTable']->value,'show_parent_id'=>$_smarty_tpl->tpl_vars['item']->value['id'],'level'=>$_smarty_tpl->tpl_vars['level']->value), 0);?>

<?php }?>




<?php } ?><?php }} ?>
