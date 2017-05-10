<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/gallery/album-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1385879015590b5edfb15cb7-86858774%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40612ae80eb45735d0b39d466ef7bd9497bde3e6' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/gallery/album-list.tpl',
      1 => 1493645559,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1385879015590b5edfb15cb7-86858774',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang_url' => 0,
    'album' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edfb20ea8_64674174',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edfb20ea8_64674174')) {function content_590b5edfb20ea8_64674174($_smarty_tpl) {?><div class="thumbnail galleryAlbum">


<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/gallery/<?php echo $_smarty_tpl->tpl_vars['album']->value['url'];?>
/">
<img src="<?php echo $_smarty_tpl->tpl_vars['album']->value['pic_preview'];?>
" alt="">
</a>

<div class="caption">
	<h4><?php echo $_smarty_tpl->tpl_vars['album']->value['title'];?>
</h4>
	<p>
	posted by <?php echo $_smarty_tpl->tpl_vars['album']->value['author'];?>
, at <?php echo $_smarty_tpl->tpl_vars['album']->value['date'];?>

	</p>
	
	<p class="text-muted">
	<?php echo count($_smarty_tpl->tpl_vars['album']->value['photos']);?>
 photos, 
	<?php echo $_smarty_tpl->tpl_vars['album']->value['views'];?>
 views, 
	<?php echo $_smarty_tpl->tpl_vars['album']->value['shares'];?>
 shares, 
	<?php echo $_smarty_tpl->tpl_vars['album']->value['comments'];?>
 comments
	</p>
	<br />
	<p><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/gallery/<?php echo $_smarty_tpl->tpl_vars['album']->value['url'];?>
/" class="btn btn-primary" role="button">Album details</a></p>
</div>


</div> <!-- galleryAlbum -->
<?php }} ?>
