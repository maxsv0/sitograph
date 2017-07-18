<?php

function BlogInstall($module) {
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
    MSV_Structure_add($itemStructure, array("lang" => "all"));

    // add email notify template
    $templateBlogNotifyAdmin = '
Blog article details:<br />
Title: <strong>{name}</strong> <br />
Name Title: <strong>{name_title}</strong> <br />
Date: <strong>{date}</strong> <br />
IP: <strong>{ip}</strong> <br />
Text: <br />
{text}<br />
';
    $itemTemplate = array(
        "name" => "blog_admin_notify",
        "subject" => "New blog article",
        "text" => $templateBlogNotifyAdmin,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    // add sample article
    $docContent = file_get_contents($module->pathModule."install-blog-folder-structure.html");
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 22:12:23",
        "email" => "tech@sitograph.com",
        "url" => "folder-structure-and-usage",
        "title" => "Folder structure and usage",
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog_1.jpg",
        "pic_preview" => "images/blog_1.jpg",
    );
    $result = MSV_Blog_add($item, array("LoadPictures"));

    // add sample article
    $docContent = file_get_contents($module->pathModule."install-blog-gallery.html");
    $item = array(
        "sticked" => 0,
        "album_id" => 1,
        "date" => "2017-07-07 22:41:28",
        "email" => "cyhiso",
        "url" => "the-beautiful-photo-gallery-is-attached-to-this-post",
        "title" => "The Beautiful photo gallery is attached to this post",
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog_2.jpg",
        "pic_preview" => "images/blog_2.jpg",
    );
    $result = MSV_Blog_add($item, array("LoadPictures"));

    // add sample article
    $docContent = file_get_contents($module->pathModule."install-blog-layers.html");
    $item = array(
        "sticked" => 0,
        "date" => "2017-07-07 22:51:13",
        "email" => "tech@sitograph.com",
        "url" => "php-framework-layers",
        "title" => "PHP Framework Layers",
        "description" => "",
        "text" => $docContent,
        "pic" => "images/blog_3.jpg",
        "pic_preview" => "images/blog_3.jpg",
    );
    $result = MSV_Blog_add($item, array("LoadPictures"));

}
