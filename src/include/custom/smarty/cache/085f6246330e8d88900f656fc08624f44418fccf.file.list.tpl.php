<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:33:40
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/structure/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1208828575590b8214c5ebe7-26930877%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '085f6246330e8d88900f656fc08624f44418fccf' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/structure/list.tpl',
      1 => 1493648338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1208828575590b8214c5ebe7-26930877',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_list' => 0,
    'listTable' => 0,
    'table_sort' => 0,
    'lang_url' => 0,
    'admin_section' => 0,
    'admin_table' => 0,
    'table_sortd_rev' => 0,
    't' => 0,
    'table_sortd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b8214c944e6_08838024',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b8214c944e6_08838024')) {function content_590b8214c944e6_08838024($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars["listTable"] = new Smarty_variable($_smarty_tpl->tpl_vars['admin_list']->value, null, 0);?>

<?php if ($_smarty_tpl->tpl_vars['listTable']->value) {?>
<div class="table-responsive">
<table id="structure-table" class="table table-hover table-striped table-module">
<tr>
<th style="width:20px;">
&nbsp;
</th>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="name") {?> class='colactive'<?php }?>>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=name&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.name"];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="name") {?><?php if ($_smarty_tpl->tpl_vars['table_sortd']->value=="asc") {?>&darr;<?php } else { ?>&uarr;<?php }?><?php }?>
</th>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="url") {?> class='colactive'<?php }?>>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=url&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.url"];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="url") {?><?php if ($_smarty_tpl->tpl_vars['table_sortd']->value=="asc") {?>&darr;<?php } else { ?>&uarr;<?php }?><?php }?>
</th>
<th class="text-nowrap"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.template"];?>
 / <?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.page_template"];?>
</th>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="access") {?> class='colactive'<?php }?>>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=access&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.access"];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="access") {?><?php if ($_smarty_tpl->tpl_vars['table_sortd']->value=="asc") {?>&darr;<?php } else { ?>&uarr;<?php }?><?php }?>
</th>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="sitemap") {?> class='colactive'<?php }?>>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=sitemap&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.sitemap"];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="sitemap") {?><?php if ($_smarty_tpl->tpl_vars['table_sortd']->value=="asc") {?>&darr;<?php } else { ?>&uarr;<?php }?><?php }?>
</th>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="published") {?> class='colactive'<?php }?>>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=published&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.published"];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="published") {?><?php if ($_smarty_tpl->tpl_vars['table_sortd']->value=="asc") {?>&darr;<?php } else { ?>&uarr;<?php }?><?php }?>
</th>
<th<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="updated") {?> class='colactive'<?php }?>>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&table=<?php echo $_smarty_tpl->tpl_vars['admin_table']->value;?>
&sort=updated&sortd=<?php echo $_smarty_tpl->tpl_vars['table_sortd_rev']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value["table.structure.updated"];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['table_sort']->value=="updated") {?><?php if ($_smarty_tpl->tpl_vars['table_sortd']->value=="asc") {?>&darr;<?php } else { ?>&uarr;<?php }?><?php }?>
</th>
<th><?php echo $_smarty_tpl->tpl_vars['t']->value["actions"];?>
</th>
</tr>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/structure/list-level.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('show_parent_id'=>0,'level'=>1), 0);?>


</div>
</table>
<?php } else { ?>

<div class="col-sm-6 col-md-offset-2">
<div class="alert alert-info"><?php echo $_smarty_tpl->tpl_vars['t']->value["not_found"];?>
</div>
</div>

<?php }?> 

<div class="col-sm-6">
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=<?php echo $_smarty_tpl->tpl_vars['admin_section']->value;?>
&add_new" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span><?php echo $_smarty_tpl->tpl_vars['t']->value["btn.add_new"];?>
</a>
</div>


<?php }} ?>
