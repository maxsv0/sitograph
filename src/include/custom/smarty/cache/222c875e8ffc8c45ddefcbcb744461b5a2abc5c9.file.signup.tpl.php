<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:53:56
         compiled from "/Users/max/sitograph/src/templates/default/user/signup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:301619390590b853b72afe4-61079744%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '222c875e8ffc8c45ddefcbcb744461b5a2abc5c9' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/user/signup.tpl',
      1 => 1493927635,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '301619390590b853b72afe4-61079744',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b853b7365f3_15293269',
  'variables' => 
  array (
    'users_registration_allow' => 0,
    'admin_email' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b853b7365f3_15293269')) {function content_590b853b7365f3_15293269($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['users_registration_allow']->value) {?>

<form class="form-horizontal" method="POST" >
  <div class="form-group">
    <label for="inputEmail" class="col-sm-4 control-label"><?php echo _t("users.form.email");?>
 <span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo _t("users.form.email");?>
" name="email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-sm-4 control-label"><?php echo _t("users.form.password");?>
 <span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="inputPassword" placeholder="<?php echo _t("users.form.password");?>
" name="password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword2" class="col-sm-4 control-label"><?php echo _t("users.form.repeat_password");?>
 <span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="inputPassword2" placeholder="<?php echo _t("users.form.repeat_password");?>
" name="password2">
    </div>
  </div>
  <div class="form-group">
    <label for="inputName" class="col-sm-4 control-label"><?php echo _t("users.form.name");?>
</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputName" placeholder="<?php echo _t("users.form.name");?>
" name="name">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPhone" class="col-sm-4 control-label"><?php echo _t("users.form.phone");?>
</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPhone" placeholder="<?php echo _t("users.form.phone");?>
" name="phone">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <button type="submit" class="btn btn-lg btn-primary" name="doSingUp" value="1"><?php echo _t("users.form.sign_up");?>
</button>
    </div>
  </div>
</form>

<?php } else { ?>

<div class="alert alert-danger">
Registration is not allowed. 
<?php if ($_smarty_tpl->tpl_vars['admin_email']->value) {?>
<br>Please contact website administrator at
<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['admin_email']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['admin_email']->value;?>
</a>
<?php }?>
</div>

<?php }?>


<div style="height:100px;"></div><?php }} ?>
