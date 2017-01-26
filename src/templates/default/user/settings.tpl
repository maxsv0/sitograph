<div class="col-md-6">
<h2>My settings</h2>

<form class="form-horizontal" method="POST" >

{if $user.email_verified}
	<div class="form-group has-success has-feedback">
	    <label for="inputEmail" class="col-sm-4 control-label">{_t("users.form.email")} <span class="text-danger">*</span></label>
	    <div class="col-sm-8">
	      <input type="email" class="form-control" id="inputEmail" value="{$user.email}" placeholder="{_t("users.form.email")}" name="user_email" aria-describedby="inputSuccess2Status">
	      <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	      <small class="text-success">{_t("email_verified")}</small>
	    </div>
	</div>
{else}
	<div class="form-group has-warning has-feedback">
	    <label for="inputEmail" class="col-sm-4 control-label">{_t("users.form.email")} <span class="text-danger">*</span></label>
	    <div class="col-sm-8">
	      <input type="email" class="form-control" id="inputEmail" value="{$user.email}" placeholder="{_t("users.form.email")}" name="user_email" aria-describedby="inputSuccess2Status">
	      <span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
	      <small class="text-warning">{_t("verification_sent")} <a href="/settings/?doVerify">{_t("resend_verification")}</a></small>
	    </div>
	</div>
{/if}



  
  <div class="form-group">
    <label for="inputName" class="col-sm-4 control-label">{_t("users.form.name")} <span class="text-danger">*</span></label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputName" value="{$user.name}" placeholder="{_t("users.form.name")}" name="user_name">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPhone" class="col-sm-4 control-label">{_t("users.form.phone")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPhone" value="{$user.phone}" placeholder="{_t("users.form.phone")}" name="user_phone">
    </div>
  </div>
  <div class="form-group">
    <label for="inputCountry" class="col-sm-4 control-label">{_t("users.form.country")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputCountry" value="{$user.country}" placeholder="{_t("users.form.country")}" name="user_country">
    </div>
  </div>
  <div class="form-group">
    <label for="inputCity" class="col-sm-4 control-label">{_t("users.form.city")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputCity" value="{$user.city}" placeholder="{_t("users.form.city")}" name="user_city">
    </div>
  </div>
  <div class="form-group">
    <label for="inputTimezone" class="col-sm-4 control-label">{_t("users.form.timezone")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputTimezone" value="{$user.timezone}"  name="user_timezone">
    </div>
  </div>
  <div class="form-group">
    <label for="inputWebsite" class="col-sm-4 control-label">{_t("users.form.website")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputWebsite" value="{$user.website}"  name="user_website" placeholder="{_t("users.form.website")}">
    </div>
  </div>
  
  
  <div class="form-group">
    <label for="inputUrl" class="col-sm-4 control-label">{_t("users.form.url")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputUrl" value="{$user.url}"  name="user_url">
    </div>
  </div>

  <div class="form-group">
    <label for="inputCompany" class="col-sm-4 control-label">{_t("users.form.company")}</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputCompany" value="{$user.company}"  name="user_company">
    </div>
  </div>
  <div class="form-group">
    <label for="inputCompanyInfo" class="col-sm-4 control-label">{_t("users.form.company_info")}</label>
    <div class="col-sm-8">
    <textarea class="form-control" id="inputCompanyInfo" name="company_info">{$user.company_info}</textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
      <button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
      <button type="submit" name="doSave" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.save"]}</button>
    </div>
  </div>
</form>

</div>




<div class="col-md-6">
<h2>Change password</h2>

<form class="form-horizontal" method="POST" >
  
  <div class="form-group">
    <label for="inputName" class="col-sm-6 control-label">Current Password</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputName" value="" placeholder="Password" name="password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputName" class="col-sm-6 control-label">New Password</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputName" value="" placeholder="Password" name="password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPhone" class="col-sm-6 control-label">Password confirmation</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputPhone" value="" placeholder="Phone" name="password2">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-6 col-sm-6">
      <button type="submit" class="btn btn-primary" name="password_save" value="1">Save changes</button>
    </div>
  </div>
</form>

</div>


