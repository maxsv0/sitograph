<?php

function UsersInstall($module) {

    MSV_Structure_add("all", "/user/", _t("structure.users.account"), "custom", "user.tpl", 1, "user", 1, "user");
    MSV_Structure_add("all", "/signup/", _t("structure.users.signup"), "custom", "user-signup.tpl", 1, "nouser", 1, "everyone", "/user/");
    MSV_Structure_add("all", "/login/", _t("structure.users.login"), "custom", "user-login.tpl", 1, "nouser", 2, "everyone", "/user/");
    MSV_Structure_add("all", "/password-reset/", _t("structure.users.password_reset"), "custom", "user-password-reset.tpl", 1, "", 0, "everyone", "/user/");
    MSV_Structure_add("all", "/settings/", _t("structure.users.settings"), "custom", "user-settings.tpl", 1, "user", 2, "user", "/user/");

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

    MSV_MailTemplate_add("user_registration", "Welcome to {HOST}", $templateRegister, $header, "all");
    MSV_MailTemplate_add("user_registration_verify", "Welcome to {HOST}", $templateRegisterConfirm, $header, "all");
    MSV_MailTemplate_add("user_registration_notify", "New user {HOST}", $templateRegisterNotify, $header, "all");
    MSV_MailTemplate_add("user_verify", "Verify Email", $templateVerify, $header, "all");
    MSV_MailTemplate_add("user_password_reset", "New Password", $templatePasswordReset, $header, "all");
    MSV_MailTemplate_add("user_password_reset_confirm", "Reset Password", $templatePasswordResetConfirm, $header, "all");
}