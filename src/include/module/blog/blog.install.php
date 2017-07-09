<?php

function BlogInstall($module) {
    // create website structure item
    MSV_Structure_add("all", $module->baseUrl, "Blog", "custom", "main-blog.tpl", 1, "top", 10, "everyone");

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
    MSV_MailTemplate_add("blog_admin_notify", "New blog article", $templateBlogNotifyAdmin, "", "all");

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
    $result = Blog_Add($item, array("LoadPictures"));

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
    $result = Blog_Add($item, array("LoadPictures"));

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
    $result = Blog_Add($item, array("LoadPictures"));

}
