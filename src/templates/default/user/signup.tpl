<div class="col-md-6 col-md-offset-3">
<h2>{_t("users.form.title_sign_up")}</h2>

<form class="form-horizontal" method="POST" >
  <div class="form-group">
    <label for="inputEmail" class="col-sm-4 control-label">{_t("users.form.email")} <span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="email" class="form-control" id="inputEmail" placeholder="{_t("users.form.email")}" name="email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-sm-4 control-label">{_t("users.form.password")} <span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="inputPassword" placeholder="{_t("users.form.password")}" name="password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword2" class="col-sm-4 control-label">{_t("users.form.repeat_password")} <span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="inputPassword2" placeholder="{_t("users.form.repeat_password")}" name="password2">
    </div>
  </div>
  <div class="form-group">
    <label for="inputName" class="col-sm-4 control-label">{_t("users.form.name")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputName" placeholder="{_t("users.form.name")}" name="name">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPhone" class="col-sm-4 control-label">{_t("users.form.phone")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPhone" placeholder="{_t("users.form.phone")}" name="phone">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
      <button type="submit" class="btn btn-primary" name="doSingUp" value="1">{_t("users.form.sign_up")}</button>
    </div>
  </div>
</form>

</div>

