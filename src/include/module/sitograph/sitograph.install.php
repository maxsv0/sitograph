<?php

function Install_Sitograph($module) {

    // create Admin UI pages
    $itemStructure = array(
        "url" => "/admin/",
        "name" => _t("structure.admin_homepage"),
        "template" => "custom",
        "page_template" => "sitograph.tpl",
        "access" => "admin",
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    $itemStructure = array(
        "url" => "/admin/login/",
        "name" => _t("structure.admin_login"),
        "template" => "custom",
        "page_template" => "sitograph-login.tpl",
        "access" => "everyone",
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    // add top MENU item
    $item = array(
        "published" => 1,
        "url" => "#",
        "name" => "Sitograph",
        "menu_id" => "top",
        "order_id" => 3,
    );
    $result = db_add(TABLE_MENU, $item);
    $menu_parent_id = $result["insert_id"];

    // create sample site structure
    $docContent = msv_load_module_doc($module->pathModule, "page-getting-started");
    $itemStructure = array(
        "url" => "/sitograph/getting-started/",
        "name" => _t("structure.getting_started"),
        "template" => "custom",
        "page_template" => "main.tpl",
        "menu" => "top",
        "menu_order" => 5,
        "menu_parent_id" => $menu_parent_id,
        "document_title" => _t("structure.getting_started"),
        "document_text" => $docContent,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    $docContent = msv_load_module_doc($module->pathModule, "page-file-structure");
    $itemStructure = array(
        "url" => "/sitograph/file-structure/",
        "name" => _t("structure.file_structure"),
        "template" => "custom",
        "page_template" => "main-sideblock.tpl",
        "menu" => "top",
        "menu_order" => 10,
        "menu_parent_id" => $menu_parent_id,
        "document_title" => _t("structure.file_structure"),
        "document_text" => $docContent,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    $docContent = msv_load_module_doc($module->pathModule, "page-api");
    $itemStructure = array(
        "url" => "/sitograph/API/",
        "name" => _t("structure.api"),
        "template" => "custom",
        "page_template" => "main-sideblock.tpl",
        "menu" => "top",
        "menu_order" => 15,
        "menu_parent_id" => $menu_parent_id,
        "document_title" => _t("structure.api"),
        "document_text" => $docContent,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    $itemStructure = array(
        "url" => "/sitograph/modules/",
        "name" => _t("structure.sitograph_modules"),
        "template" => "custom",
        "page_template" => "main-modules.tpl",
        "menu" => "top",
        "menu_order" => 20,
        "menu_parent_id" => $menu_parent_id,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    // update homepage doc
    $resultQuery = db_get_list(TABLE_STRUCTURE, "`url` like '/'");
    if ($resultQuery["ok"]) {
        foreach ($resultQuery["data"] as $structure) {
            if (empty($structure["page_document_id"])) {
                continue;
            }

            $docContent = msv_load_module_doc($module->pathModule, "page-homepage");

            $result = db_update(TABLE_DOCUMENTS, "text", "'" . db_escape($docContent) . "'", " `id` = '" . $structure["page_document_id"] . "'");
            if (!$result["ok"]) {
                msv_message_error($result["msg"]);
            }
        }
    }

    // mailing options
    msv_set_config("email_from", "tech@sitograph.com", true, "*");
    msv_set_config("email_fromname", "Sitograph", true, "*");

    msv_set_config("theme_copyright_text", "2016-2017 <a href='http://sitograph.com/' target='_blank'>Sitograph</a>", true, "*");
    msv_set_config("theme_header_contacts", "<a href='https://discord.gg/tPusyxP'>Join Discord channel</a><br>Skype: max.svistunov", true, "*");

    msv_set_config("service_ua_info", "curl -X POST -H 'Content-Type: application/json' -d '{\"useragent\":\"{ua}\"}' https://useragentinfo.co/device", true, "*");
    msv_set_config("service_ip_info", "curl -X POST -H 'Content-Type: application/json' -d '{\"ip\":\"{ip}\"}' https://useragentinfo.co/ip", true, "*");

    if (LANG === "ru" || LANG === "ua") {
        msv_set_config("theme_logo", "/content/images/sitograph/sitograph-logo-dark-ru.png", true, "*");
    } else {
        msv_set_config("theme_logo", "/content/images/sitograph/sitograph-logo-dark-en.png", true, "*");
    }
    msv_set_config("theme_bg", "/content/images/bg_full.jpg", true, "*");
    msv_set_config("theme_cms_favicon", "/content/images/sitograph/cms_favicon.gif", true, "*");

    // add mail templates
    $header = '
<style type="text/css">
* {font-family: Arial, sans-serif; }
strong {color:#bb233a;}
a {color:#bb233a;}
a:link {color:#bb233a;}
a:visited {color:#bb233a;}
a:hover {color:#bb233a;}
a:active {color:#bb233a;}
</style>
';

    $templateHeader = msv_load_module_doc($module->pathModule, "mail_template_header");
    $templateFooter = msv_load_module_doc($module->pathModule, "mail_template_footer");

    // update all Email Templates, adding Sitograph header and footer
    $resultQuery = db_get_list(TABLE_MAIL_TEMPLATES);
    if ($resultQuery["ok"]) {
        foreach ($resultQuery["data"] as $template) {
            $templateBody = $templateHeader.$template["text"].$templateFooter;

            $result = db_update(TABLE_MAIL_TEMPLATES, "header", "'".db_escape($header)."'", " `id` = '".$template["id"]."'");
            if (!$result["ok"]) {
                msv_message_error($result["msg"]);
            }

            $result = db_update(TABLE_MAIL_TEMPLATES, "text", "'".db_escape($templateBody)."'", " `id` = '".$template["id"]."'");
            if (!$result["ok"]) {
                msv_message_error($result["msg"]);
            }
        }
    }

    // add gallery
    $item = array(
        "date" => "2017-07-01 13:50:12",
        "url" => "Sitograph-CMS-Screenshots",
        "title" => "Sitograph CMS Screenshots",
        "description" => "Sitograph CMS Admin UI Screenshots",
        "pic" => "images/gallery/gallery_2.jpg",
        "pic_preview" => "images/gallery/gallery_2.jpg",
        "photos" => array(
            array(
                "date" => "2017-07-01 10:23:12",
                "title" => "Login page",
                "description" => "Login page",
                "pic" => "images/gallery/gallery_photo1_1.jpg",
                "pic_preview" => "images/gallery/gallery_photo1_1.jpg",
            ),
//            array(
//                "date" => "2017-07-01 10:25:22",
//                "title" => "Admin Homepage",
//                "description" => "Admin Homepage",
//                "pic" => "images/gallery_photo1_2.jpg",
//                "pic_preview" => "images/gallery_photo1_2.jpg",
//            ),
            array(
                "date" => "2017-07-01 10:33:10",
                "title" => "Website Structure Table",
                "description" => "Website Structure Table",
                "pic" => "images/gallery/gallery_photo1_3.jpg",
                "pic_preview" => "images/gallery/gallery_photo1_3.jpg",
            ),
            array(
                "date" => "2017-07-01 10:43:42",
                "title" => "Website Menu",
                "description" => "Website Menu - edit item settings",
                "pic" => "images/gallery/gallery_photo1_4.jpg",
                "pic_preview" => "images/gallery/gallery_photo1_4.jpg",
            ),
            array(
                "date" => "2017-07-01 10:45:42",
                "title" => "Blog",
                "description" => "Blog - edit attached pictures",
                "pic" => "images/gallery/gallery_photo1_5.jpg",
                "pic_preview" => "images/gallery/gallery_photo1_5.jpg",
            ),
            array(
                "date" => "2017-07-01 10:43:50",
                "title" => "Email templates",
                "description" => "Email templates",
                "pic" => "images/gallery/gallery_photo1_6.jpg",
                "pic_preview" => "images/gallery/gallery_photo1_6.jpg",
            ),
        )
    );
    $result = api_gallery_add($item, array("LoadPictures"));
    $album_id = $result["insert_id"];

    // add blog posts
    //$docContent = file_get_contents($module->pathModule."install-blog-folder-structure.html");
    $item = array(
        "sticked" => 0,
        "album_id" => $album_id,
        "date" => "2017-07-07 23:50:18",
        "email" => "support@sitograph.com",
        "url" => "Sitograph-CMS-Screenshots",
        "title" => "Sitograph CMS Screenshots",
        "description" => "Sitograph CMS Admin UI",
        "text" => "<p>User Interface screenshots for website administrator</p>",
        "pic" => "images/blog/blog_sitograph_1.jpg",
        "pic_preview" => "images/blog/blog_sitograph_1.jpg",
    );
    api_blog_add($item, array("LoadPictures"));


    // add gallery
    $item = array(
        "date" => "2017-07-01 13:50:12",
        "url" => "sitograph-installation-wizard",
        "title" => "Sitograph Installation Wizard",
        "description" => "Installing Sitograph CMS and default website content",
        "pic" => "images/gallery/gallery3_photo1.jpg",
        "pic_preview" => "images/gallery/gallery3_photo1.jpg",
        "photos" => array(
            array(
                "date" => "2017-08-12 11:23:12",
                "title" => "Step 1. Welcome page",
                "description" => "Step 1. Welcome page",
                "pic" => "images/gallery/gallery3_photo1.jpg",
                "pic_preview" => "images/gallery/gallery3_photo1.jpg",
            ),
            array(
                "date" => "2017-08-12 11:25:22",
                "title" => "Step 2. Setting-up config.php",
                "description" => "Step 2. Setting-up config.php",
                "pic" => "images/gallery/gallery3_photo2.jpg",
                "pic_preview" => "images/gallery/gallery3_photo2.jpg",
            ),
            array(
                "date" => "2017-08-12 11:33:10",
                "title" => "Step 3. Select modules to install and create administrator",
                "description" => "Step 3. Select modules to install and create administrator",
                "pic" => "images/gallery/gallery3_photo3.jpg",
                "pic_preview" => "images/gallery/gallery3_photo3.jpg",
            ),
            array(
                "date" => "2017-08-12 11:43:42",
                "title" => "Step 4. Finish setup",
                "description" => "Step 4. Finish setup",
                "pic" => "images/gallery/gallery3_photo4.jpg",
                "pic_preview" => "images/gallery/gallery3_photo4.jpg",
            ),
        )
    );
    $result = api_gallery_add($item, array("LoadPictures"));
    $album_id = $result["insert_id"];

    $docContent = msv_load_module_doc($module->pathModule, "blog-install");
    $item = array(
        "sticked" => 0,
        "album_id" => $album_id,
        "date" => "2017-07-07 23:54:19",
        "email" => "support@sitograph.com",
        "url" => "installing-sitograph-cms",
        "title" => "Installing Sitograph CMS",
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog/blog_sitograph_2.jpg",
        "pic_preview" => "images/blog/blog_sitograph_2.jpg",
    );
    api_blog_add($item, array("LoadPictures"));

    $docContent = msv_load_module_doc($module->pathModule, "blog-release");
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 23:58:59",
        "email" => "support@sitograph.com",
        "url" => "Sitograph-v.1.0-released",
        "title" => "Sitograph CMS v.1.0 released",
        "description" => "Sitograph version 1.0 was released July 2017!",
        "text" => $docContent,
        "pic" => "images/blog/blog_sitograph_3.jpg",
        "pic_preview" => "images/blog/blog_sitograph_3.jpg",
    );
    api_blog_add($item, array("LoadPictures"));


}