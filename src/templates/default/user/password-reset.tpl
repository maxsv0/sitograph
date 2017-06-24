
<form class="form-horizontal" method="POST" action="{$lang_url}/password-reset/">
  <div class="form-group">
    <div class="col-sm-10 col-sm-offset-1">
      {_t("users.password_reset")}
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">{_t("users.form.email")}</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail" placeholder="{_t("users.form.email")}" name="email">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-lg btn-primary" name="doPasswordReset" value="1">{_t("users.form.password_reset")}</button>
    </div>
  </div>

</form>

<div style="height:100px;"></div>