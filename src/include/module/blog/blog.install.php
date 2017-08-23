<?php

function Install_Blog($module) {
    // create website structure item
    $itemStructure = array(
        "url" => $module->baseUrl,
        "name" => "Blog",
        "template" => "custom",
        "page_template" => "main-blog.tpl",
        "sitemap" => 1,
        "menu" => "top",
        "menu_order" => 10,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    // add email notify template
    $templateBlogNotifyAdmin = msv_load_module_doc($module->pathModule, "mail_template_admin_notify");

    $itemTemplate = array(
        "name" => "blog_admin_notify",
        "subject" => "New blog article",
        "text" => $templateBlogNotifyAdmin,
    );
    msv_add_mailtemplate($itemTemplate, array("lang" => "all"));

    // add sample article
    $docContent = msv_load_module_doc($module->pathModule, "blog-folder-structure");
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 22:12:23",
        "email" => "tech@sitograph.com",
        "url" => "folder-structure-and-usage",
        "title" => _t("blog.post1"),
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog/blog_1.jpg",
        "pic_preview" => "images/blog/blog_1.jpg",
    );
    $result = api_blog_add($item, array("LoadPictures"));

    // add sample article
    $docContent = msv_load_module_doc($module->pathModule, "blog-gallery");
    $item = array(
        "sticked" => 0,
        "album_id" => 1,
        "date" => "2017-07-07 22:41:28",
        "email" => "cyhiso",
        "url" => "the-beautiful-photo-gallery-is-attached-to-this-post",
        "title" => _t("blog.post1"),
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog/blog_2.jpg",
        "pic_preview" => "images/blog/blog_2.jpg",
    );
    $result = api_blog_add($item, array("LoadPictures"));

    // add sample article
    $docContent = msv_load_module_doc($module->pathModule, "blog-layers");
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 22:51:13",
        "email" => "tech@sitograph.com",
        "url" => "php-framework-layers",
        "title" => _t("blog.post3"),
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog/blog_3.jpg",
        "pic_preview" => "images/blog/blog_3.jpg",
    );
    $result = api_blog_add($item, array("LoadPictures"));

}
