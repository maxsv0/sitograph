<form class="form-horizontal" method="POST" action="{$lang_url}/login/">
  <div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">{_t("users.form.email")}</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail" placeholder="{_t("users.form.email")}" name="email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-sm-2 control-label">{_t("users.form.password")}</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="{_t("users.form.password")}" name="password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <div class="checkbox">
        <label>
          <input type="checkbox" checked> {_t("users.form.remember_me")}
        </label>
      </div>
    </div>
    <div class="col-sm-4 text-right">
      <a href="{$lang_url}/password-reset/">{_t("users.form.link_forget")}</a>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
      <button type="submit" class="btn btn-lg btn-primary" name="doLogin" value="1">{_t("users.form.sign_in")}</button>
    </div>
    <div class="col-sm-offset-1 col-sm-5">
      <a href="{$google_user_auth_url}"><img src="/content/images/btn_google_signin.png" title="{_t("users.form.sign_in_with_google")}" class="img-responsive"></a>
    </div>
  </div>
</form>

<div style="height:100px;"></div>