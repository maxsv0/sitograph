<?php

function UsersInstall($module) {

    $itemStructure = array(
        "url" => "/user/",
        "name" =>  _t("structure.users.account"),
        "template" => "custom",
        "page_template" => "user.tpl",
        "sitemap" => 1,
        "access" => "user",
        "menu" => "user",
        "menu_order" => 1,
    );
    MSV_Structure_add($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/signup/",
        "name" =>  _t("structure.users.signup"),
        "parent_url" => "/user/",
        "template" => "custom",
        "page_template" => "user-signup.tpl",
        "sitemap" => 1,
        "access" => "everyone",
        "menu" => "nouser",
        "menu_order" => 1,
    );
    MSV_Structure_add($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/login/",
        "name" =>  _t("structure.users.login"),
        "parent_url" => "/user/",
        "template" => "custom",
        "page_template" => "user-login.tpl",
        "sitemap" => 1,
        "access" => "everyone",
        "menu" => "nouser",
        "menu_order" => 1,
    );
    MSV_Structure_add($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/password-reset/",
        "name" =>  _t("structure.users.password_reset"),
        "parent_url" => "/user/",
        "template" => "custom",
        "page_template" => "user-password-reset.tpl",
        "sitemap" => 1,
        "access" => "everyone",
    );
    MSV_Structure_add($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/settings/",
        "name" =>  _t("structure.users.settings"),
        "parent_url" => "/user/",
        "template" => "custom",
        "page_template" => "user-settings.tpl",
        "sitemap" => 1,
        "access" => "user",
        "menu" => "user",
        "menu_order" => 5,
    );
    MSV_Structure_add($itemStructure, array("lang" => "all"));

    $item = array(
        "published" => 1,
        "url" => "/?logout",
        "name" => "Logout",
        "menu_id" => "user",
        "order_id" => 100,
    );
    API_itemAdd(TABLE_MENU, $item, "all");

    // trigger email sending on user registration
    // default value: 1 => each user will receive email on registration
    MSV_setConfig("users_registration_email", 1, true, "*");

    // send email notification to "admin_email"
    MSV_setConfig("users_registration_email_notify", 1, true, "*");

    // allow user registration on website using form
    // default value: 0 => users can't register himself
    MSV_setConfig("users_registration_allow", 0, true, "*");

    // install emails
    $header = "";
    $templateRegister = '
Thank you for signing up to <strong>{HOST}</strong>.
<br />
Use your account data to <a href="{HOME_URL}login/">sign in</a>:<br /><br />
Login: <strong>{email}</strong><br />
Password: <strong>{password}</strong> <br />
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{support_email}">{support_email}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
';

    $templateRegisterNotify = '
New user was registered on <strong>{HOST}</strong>.
<br />
Email: <strong>{email}</strong><br />
Password: <strong>{password}</strong> <br />
Phone: <strong>{phone}</strong> <br />
ISS: <strong>{iss}</strong> <br />
Aaccess: <strong>{access}</strong> <br />
Email Verified: <strong>{email_verified}</strong> <br />
<br /><br />
';

    $templateRegisterConfirm = '
Thank you for signing up to <strong>{HOST}</strong>. <br />
To complete and confirm your registration, you’ll need to verify your email address. To do so, please click the link below:
<br /><br />
<center>
<a href="{verify_link}" style="display: block; display: inline-block; width: 200px; min-height: 20px;  padding: 10px; background-color: #bb233a; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none;">
Verify Email
</a>
</center>
<br /><br />
Use your account data to <a href="{HOME_URL}login/">sign in</a>:<br /><br />
Login: <strong>{email}</strong><br />
Password: <strong>{password}</strong> <br />
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{support_email}">{support_email}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
<br /><br />
<hr>
If you’re having trouble clicking the "Verify Email" button, copy and paste the URL below into your web browser: <br />
<a href="{verify_link}">{verify_link}</a>
';

    $templatePasswordResetConfirm = '
You are receiving this email because we received a password reset request for your account.
<br /><br />
<center>
<a href="{reset_link}" style="display: block; display: inline-block; width: 200px; min-height: 20px;  padding: 10px; background-color: #bb233a; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none;">
Reset Password
</a>
</center>
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{support_email}">{support_email}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
<br /><br />
<hr>
If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <br />
<a href="{reset_link}">{reset_link}</a>
';
    $templatePasswordReset = '
You successfully reset your password.
<br />
Login: <strong>{email}</strong><br />
Password: <strong>{password}</strong> <br />
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{support_email}">{support_email}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
';

    $templateVerify = '
To complete and confirm your registration, you’ll need to verify your email address. To do so, please click the link below:
<br /><br />
<center>
<a href="{verify_link}" style="display: block; display: inline-block; width: 200px; min-height: 20px;  padding: 10px; background-color: #bb233a; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none;">
Verify Email
</a>
</center>
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{support_email}">{support_email}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
<br /><br />
<hr>
If you’re having trouble clicking the "Verify Email" button, copy and paste the URL below into your web browser: <br />
<a href="{verify_link}">{verify_link}</a>
';

    $itemTemplate = array(
        "name" => "user_registration",
        "subject" => "Welcome to {HOST}",
        "text" => $templateRegister,
        "header" => $header,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    $itemTemplate = array(
        "name" => "user_registration_verify",
        "subject" => "Welcome to {HOST}",
        "text" => $templateRegisterConfirm,
        "header" => $header,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    $itemTemplate = array(
        "name" => "user_registration_notify",
        "subject" => "New user {HOST}",
        "text" => $templateRegisterNotify,
        "header" => $header,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    $itemTemplate = array(
        "name" => "user_verify",
        "subject" => "Verify Email",
        "text" => $templateVerify,
        "header" => $header,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    $itemTemplate = array(
        "name" => "user_password_reset",
        "subject" => "New Password",
        "text" => $templatePasswordReset,
        "header" => $header,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    $itemTemplate = array(
        "name" => "user_password_reset_confirm",
        "subject" => "Reset Password",
        "text" => $templatePasswordResetConfirm,
        "header" => $header,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));
}