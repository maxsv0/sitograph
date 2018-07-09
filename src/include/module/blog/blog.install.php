<?php


function Install_Blog($module) {
    $themeName = msv_get_config("theme_active");

    // create website structure item
    $itemStructure = array(
        "url" => $module->baseUrl,
        "name" => _t("structure.blog"),
        "template" => $themeName,
        "page_template" => "main-blog.tpl",
        "sitemap" => 1,
        "menu" => "top",
        "menu_order" => 10,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    // add email notify template
    $itemTemplate = array(
        "name" => "blog_admin_notify",
        "subject" => _t("email.blog_admin_notify"),
        "text" => msv_load_module_doc($module->pathModule, "email-admin-notify"),
    );
    msv_add_mailtemplate($itemTemplate, array("lang" => "all"));

    // add sample article
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 22:12:23",
        "email" => "tech@sitograph.com",
        "url" => "folder-structure-and-usage",
        "title" => _t("blog.post1"),
        "description" => "",
        "text" => msv_load_module_doc($module->pathModule, "blog-folder-structure"),
        "pic" => "images/blog/blog_1.jpg",
        "pic_preview" => "images/blog/blog_1.jpg",
    );
    $result = api_blog_add($item, array("LoadPictures"));

    // add sample article
    $item = array(
        "sticked" => 0,
        "album_id" => 1,
        "date" => "2017-07-07 22:41:28",
        "email" => "cyhiso",
        "url" => "the-beautiful-photo-gallery-is-attached-to-this-post",
        "title" => _t("blog.post2"),
        "description" => "",
        "text" => msv_load_module_doc($module->pathModule, "blog-gallery"),
        "pic" => "images/blog/blog_2.jpg",
        "pic_preview" => "images/blog/blog_2.jpg",
    );
    $result = api_blog_add($item, array("LoadPictures"));

    // add sample article
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 22:51:13",
        "email" => "tech@sitograph.com",
        "url" => "php-framework-layers",
        "title" => _t("blog.post3"),
        "description" => "",
        "text" => msv_load_module_doc($module->pathModule, "blog-layers"),
        "pic" => "images/blog/blog_3.jpg",
        "pic_preview" => "images/blog/blog_3.jpg",
    );
    $result = api_blog_add($item, array("LoadPictures"));

}
