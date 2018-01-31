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
    msv_set_config("email_from", "tech@sitograph.com", true, "*", _t("settings.email_from"));
    msv_set_config("email_fromname", "Sitograph", true, "*", _t("settings.email_fromname"));

    msv_set_config("theme_copyright_text", "2016-".date("Y")." Sitograph CMS. <a href='http://sitograph.com/' target='_blank'>sitograph.com</a>", true, "*");
    msv_set_config("theme_header_contacts", "<a href='https://discord.gg/tPusyxP'>Join Discord channel</a><br>Skype: max.svistunov", true, "*");

    msv_set_config("service_ua_info", "", true, "*", _t("settings.service_ua_info"), "website");
    msv_set_config("service_ip_info", "", true, "*", _t("settings.service_ip_info"), "website");

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
        "pic" => "images/gallery/gallery2_photo_1.jpg",
        "pic_preview" => "images/gallery/gallery2_photo_1.jpg",
        "photos" => array(
            array(
                "date" => "2017-07-01 10:23:12",
                "title" => "Login page",
                "description" => "Login page",
                "pic" => "images/gallery/gallery2_photo_login.jpg",
                "pic_preview" => "images/gallery/gallery2_photo_login.jpg",
            ),
            array(
                "date" => "2017-07-01 10:25:22",
                "title" => "Admin Homepage",
                "description" => "Admin Homepage",
                "pic" => "images/gallery2_photo_1.jpg",
                "pic_preview" => "images/gallery2_photo_1.jpg",
            )
        )
    );
    for ($i = 2; $i < 25; $i++) {
        $item["photos"][] = array(
            "pic" => "images/gallery2_photo_".$i.".jpg",
            "pic_preview" => "images/gallery2_photo_".$i.".jpg",
        );
    }
    $result = api_gallery_add($item, array("LoadPictures"));
    $album_id = $result["insert_id"];

    // add blog posts
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
    $docContent = msv_load_module_doc($module->pathModule, "sitograph-install");
    $item = array(
        "date" => "2017-12-23 13:50:12",
        "url" => "sitograph-installation-wizard",
        "title" => "Sitograph Installation Wizard",
        "description" => $docContent,
        "pic" => "images/gallery/gallery3_photo1.jpg",
        "pic_preview" => "images/gallery/gallery3_photo1.jpg",
        "photos" => array(
            array(
                "date" => "2017-12-23 10:23:12",
                "title" => "Step 1. Welcome page",
                "description" => "Step 1. Welcome page",
                "pic" => "images/gallery/gallery3_photo1.jpg",
                "pic_preview" => "images/gallery/gallery3_photo1.jpg",
            ),
            array(
                "date" => "2017-12-23 10:25:22",
                "title" => "Step 2. Setting-up config.php",
                "description" => "Step 2. Setting-up config.php",
                "pic" => "images/gallery/gallery3_photo2.jpg",
                "pic_preview" => "images/gallery/gallery3_photo2.jpg",
            ),
            array(
                "date" => "2017-12-23 10:33:10",
                "title" => "Step 3. Select modules to install and create administrator",
                "description" => "Step 3. Select modules to install and create administrator",
                "pic" => "images/gallery/gallery3_photo3.jpg",
                "pic_preview" => "images/gallery/gallery3_photo3.jpg",
            ),
            array(
                "date" => "2017-12-23 10:43:42",
                "title" => "Step 4. Finish setup",
                "description" => "Step 4. Finish setup",
                "pic" => "images/gallery/gallery3_photo4.jpg",
                "pic_preview" => "images/gallery/gallery3_photo4.jpg",
            ),
            array(
                "date" => "2017-12-23 10:43:42",
                "title" => "Default website",
                "description" => "Default website after successful installation",
                "pic" => "images/gallery/gallery3_photo5.jpg",
                "pic_preview" => "images/gallery/gallery3_photo5.jpg",
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

    // create admin manual
    $manualTopics = array(
        "release" => array(
            "title" => "Sitograph CMS v.1.0 released",
            "content" => msv_load_module_doc(ABS_INCLUDE."/module/sitograph/", "blog-release")
        ),
        "install" => array(
            "title" => "Installing Sitograph CMS",
            "preview" => "images/blog/blog_sitograph_2.jpg",
            "content" => msv_load_module_doc(ABS_INCLUDE."/module/sitograph/", "blog-install")
        ),
        "folder-structure" => array(
            "title" => _t("blog.post1"),
            "content" => msv_load_module_doc(ABS_INCLUDE."/module/blog/", "blog-folder-structure")
        ),
        "getting-started" => array(
            "title" => _t("structure.getting_started"),
            "content" => msv_load_module_doc(ABS_INCLUDE."/module/sitograph/", "page-getting-started")
        ),
        "cms_file_structure" => array(
            "title" => _t("structure.file_structure"),
            "content" => msv_load_module_doc(ABS_INCLUDE."/module/sitograph/", "page-file-structure")
        ),
        "api" => array(
            "title" => _t("structure.api"),
            "content" => msv_load_module_doc(ABS_INCLUDE."/module/sitograph/", "page-api")
        ),
        "api" => array(
            "title" => _t("blog.post3"),
            "preview" => "images/blog/blog_3.jpg",
            "content" => msv_load_module_doc(ABS_INCLUDE."/module/blog/", "blog-layers")
        ),
    );

    $i = 1;
    $tabContent = "";
    $tabHeader = "";
    foreach ($manualTopics as $topicName => $topicInfo) {
        if ($i == 1) {
            $tabContent .= "<div id=\"$topicName\" class=\"tab-pane fade in active\">";
            $tabHeader .= "<li class=\"active\"><a data-toggle=\"tab\" href=\"#$topicName\">{$topicInfo["title"]}</a></li>";
        } else {
            $tabHeader .= "<li><a data-toggle=\"tab\" href=\"#$topicName\">{$topicInfo["title"]}</a></li>";
            $tabContent .= "<div id=\"$topicName\" class=\"tab-pane fade\">";
        }

        if (!empty($topicInfo["title"])) {
            $tabContent .= "<h1>{$topicInfo["title"]}</h1>\n";
        }

        if (!empty($topicInfo["preview"])) {
            $tabContent .= "<p><img src='".CONTENT_URL."/".$topicInfo["preview"]."' class='img-responsive'></p>\n";
        }

        $tabContent .= "
  {$topicInfo["content"]}
</div>
";
        $i++;
    }

    $manualContent = "
<div class='row'>
    <div class='col-sm-8'>
        <div class='tab-content'>$tabContent</div>
    </div>
    <div class='col-sm-4'>
        <ul class='nav well well-sm'>$tabHeader</ul>
    </div>
</div>
";
    $manualPath = ABS."/content/manual.html";
    file_put_contents($manualPath, $manualContent);
}