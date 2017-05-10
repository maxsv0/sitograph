<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:46:52
         compiled from "/Users/max/sitograph/src/templates/default/user/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:454220423590b852cc8fea3-06752649%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf4cce79463d7ddee07d45dd64b3f3db97ad3443' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/user/login.tpl',
      1 => 1493650438,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '454220423590b852cc8fea3-06752649',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b852cc968e5_17628152',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b852cc968e5_17628152')) {function content_590b852cc968e5_17628152($_smarty_tpl) {?><form class="form-horizontal" method="POST" action="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/login/">
  <div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label"><?php echo _t("users.form.email");?>
</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail" placeholder="<?php echo _t("users.form.email");?>
" name="email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-sm-2 control-label"><?php echo _t("users.form.password");?>
</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="<?php echo _t("users.form.password");?>
" name="password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <div class="checkbox">
        <label>
          <input type="checkbox" checked> <?php echo _t("users.form.remember_me");?>

        </label>
      </div>
    </div>
    <div class="col-sm-4 text-right">
      <a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/password-reset/"><?php echo _t("users.form.link_forget");?>
</a>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-lg btn-primary" name="doLogin" value="1"><?php echo _t("users.form.sign_in");?>
</button>
    </div>
  </div>
  
</form>

<div style="height:100px;"></div><?php }} ?>
