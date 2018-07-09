<?php

function Install_Users($module)
{
    $themeName = msv_get_config("theme_active");

    msv_add_structure(
        array(
            "url" => "/user/",
            "name" => _t("structure.users.account"),
            "template" => $themeName,
            "page_template" => "user.tpl",
            "sitemap" => 1,
            "access" => "user",
            "menu" => "user",
            "menu_order" => 1,
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_structure(
        array(
            "url" => "/signup/",
            "name" => _t("structure.users.signup"),
            "parent_url" => "/user/",
            "template" => $themeName,
            "page_template" => "user-signup.tpl",
            "sitemap" => 1,
            "access" => "everyone",
            "menu" => "nouser",
            "menu_order" => 1,
        ), array(
            "lang" => "all"
        )
    );

    msv_add_structure(
        array(
            "url" => "/login/",
            "name" => _t("structure.users.login"),
            "parent_url" => "/user/",
            "template" => $themeName,
            "page_template" => "user-login.tpl",
            "sitemap" => 1,
            "access" => "everyone",
            "menu" => "nouser",
            "menu_order" => 1,
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_structure(
        array(
            "url" => "/password-reset/",
            "name" => _t("structure.users.password_reset"),
            "parent_url" => "/user/",
            "template" => $themeName,
            "page_template" => "user-password-reset.tpl",
            "sitemap" => 1,
            "access" => "everyone",
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_structure(
        array(
            "url" => "/settings/",
            "name" => _t("structure.users.settings"),
            "parent_url" => "/user/",
            "template" => $themeName,
            "page_template" => "user-settings.tpl",
            "sitemap" => 1,
            "access" => "user",
            "menu" => "user",
            "menu_order" => 5,
        ),
        array(
            "lang" => "all"
        )
    );

    db_add(
        TABLE_MENU,
        array(
            "published" => 1,
            "url" => "/?logout",
            "name" => _t("users.logout"),
            "menu_id" => "user",
            "order_id" => 100,
        ),
        "all"
    );

    // trigger email sending on user registration
    // default value: 1 => each user will receive email on registration
    msv_set_config(
        "users_registration_email",
        1,
        true,
        "*",
        _t("settings.users_registration_email")
    );

    // send email notification to "admin_email"
    msv_set_config(
        "users_registration_email_notify",
        1,
        true,
        "*",
        _t("settings.users_registration_email_notify")
    );

    // allow user registration on website using form
    // default value: 0 => users can't register himself
    msv_set_config(
        "users_registration_allow",
        1,
        true,
        "*",
        _t("settings.users_registration_allow")
    );

    // install emails
    $header = "";

    msv_add_mailtemplate(
        array(
            "name" => "user_registration",
            "subject" => _t("email.user_registration"),
            "text" => msv_load_module_doc(
                $module->pathModule,
                "email-registration"
            ),
            "header" => $header,
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_mailtemplate(
        array(
            "name" => "user_registration_verify",
            "subject" => _t("email.user_registration_verify"),
            "text" => msv_load_module_doc(
                $module->pathModule,
                "email-registration-verify"),
            "header" => $header,
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_mailtemplate(
        array(
            "name" => "user_registration_notify",
            "subject" => _t("email.user_registration_notify"),
            "text" => msv_load_module_doc(
                $module->pathModule,
                "email-registration-notify"),
            "header" => $header,
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_mailtemplate(
        array(
            "name" => "user_verify",
            "subject" => _t("email.user_verify"),
            "text" => msv_load_module_doc(
                $module->pathModule,
                "email-verify"),
            "header" => $header,
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_mailtemplate(
        array(
            "name" => "user_password_reset",
            "subject" => _t("email.user_password_reset"),
            "text" => msv_load_module_doc(
                $module->pathModule,
                "email-password-reset"),
            "header" => $header,
        ),
        array(
            "lang" => "all"
        )
    );

    msv_add_mailtemplate(
        array(
            "name" => "user_password_reset_confirm",
            "subject" => _t("email.user_password_reset_confirm"),
            "text" => msv_load_module_doc(
                $module->pathModule,
                "email-password-reset-confirm"
            ),
            "header" => $header,
        ),
        array(
            "lang" => "all"
        )
    );
}