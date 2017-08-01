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
    $docContent = file_get_contents($module->pathModule."install-page-getting-started.html");
    $itemStructure = array(
        "url" => "/sitograph/getting-started/",
        "name" => "Getting Started",
        "template" => "custom",
        "page_template" => "main-sideblock.tpl",
        "menu" => "top",
        "menu_order" => 5,
        "menu_parent_id" => $menu_parent_id,
        "document_title" => "Getting Started",
        "document_text" => $docContent,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    $docContent = file_get_contents($module->pathModule."install-page-file-structure.html");
    $itemStructure = array(
        "url" => "/sitograph/file-structure/",
        "name" => "Sitograph File structure",
        "template" => "custom",
        "page_template" => "main-sideblock.tpl",
        "menu" => "top",
        "menu_order" => 10,
        "menu_parent_id" => $menu_parent_id,
        "document_title" => "Getting Started",
        "document_text" => $docContent,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    $docContent = file_get_contents($module->pathModule."install-page-api.html");
    $itemStructure = array(
        "url" => "/sitograph/API/",
        "name" => "Website API",
        "template" => "custom",
        "page_template" => "main-sideblock.tpl",
        "menu" => "top",
        "menu_order" => 15,
        "menu_parent_id" => $menu_parent_id,
        "document_title" => "Getting Started",
        "document_text" => $docContent,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    $itemStructure = array(
        "url" => "/sitograph/modules/",
        "name" => "Sitograph Modules",
        "template" => "custom",
        "page_template" => "main-modules.tpl",
        "menu" => "top",
        "menu_order" => 20,
        "menu_parent_id" => $menu_parent_id,
    );
    msv_add_structure($itemStructure, array("lang" => "*"));

    // mailing options
    msv_set_config("email_from", "tech@sitograph.com", true, "*");
    msv_set_config("email_fromname", "Sitograph", true, "*");

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

    $templateHeader = '
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding: 10px 0 30px 0;">
<table style="background-color: #ffffff; width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr style="height: 52px;">
<td style="width: 467px; height: 52px;">
<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td bgcolor="#747474" width="20" height="50">&nbsp;</td>
<td bgcolor="#747474" width="600" height="50">
<img style="display: block;" src="{HOME_URL}content/images/sitograph/sitograph-logo-white-en.png" alt="Sitograph" width="265" height="80"/>
</td>
<td bgcolor="#747474" width="20" height="50">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="height: 15px;">
<td style="width: 467px; height: 15px;">&nbsp;</td>
</tr>
<tr style="height: 400px;">
<td style="padding: 20px 20px 0px; color: #2c2c2c; font-size: 11pt; line-height: 140%; width: 467px; height: 400px;">
Dear {name},
<br /><br />
';
    $templateFooter = '
<br /><br />
Regards, <br />
Sitograph Team
</td>
</tr>
<tr style="height: 97px;">
<td style="padding: 0px 20px; color: #777777; background-color: #eeeeee; font-size: 9pt; line-height: 140%; width: 467px; height: 90px;">
<br />
<strong>Sitograph Content Management System.</strong>
Sitograph CMS is an online, open source website creation tool.
Sitograph is a set of solutions for any online business.
It is simple and powerful content management system for website or online shop.
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
';
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
        "description" => "Sitograph CMS Admin UI",
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
        "pic" => "images/blog_sitograph_1.jpg",
        "pic_preview" => "images/blog_sitograph_1.jpg",
    );
    api_blog_add($item, array("LoadPictures"));

    $docContent = file_get_contents($module->pathModule."install-blog-install.html");
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 23:54:19",
        "email" => "support@sitograph.com",
        "url" => "installing-sitograph-cms",
        "title" => "Installing Sitograph CMS",
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog_sitograph_2.jpg",
        "pic_preview" => "images/blog_sitograph_2.jpg",
    );
    api_blog_add($item, array("LoadPictures"));

    $docContent = file_get_contents($module->pathModule."install-blog-release.html");
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 23:58:59",
        "email" => "support@sitograph.com",
        "url" => "Sitograph-v.1.0.beta-released",
        "title" => "Sitograph CMS v.1.0.beta released",
        "description" => "Sitograph version 1.0.beta was released July 2017!",
        "text" => $docContent,
        "pic" => "images/blog_sitograph_3.jpg",
        "pic_preview" => "images/blog_sitograph_3.jpg",
    );
    api_blog_add($item, array("LoadPictures"));


}