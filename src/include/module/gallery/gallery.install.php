<?php

function GalleryInstall($module) {
    // create website structure item
    MSV_Structure_add("all", $module->baseUrl, "Gallery", "custom", "main-gallery.tpl", 1, "top", 10, "everyone", "");

    // add sample gallery
    $item = array(
        "date" => "2017-07-01 13:25:11",
        "url" => "the-beautiful-photo-gallery",
        "title" => "The Beautiful photo gallery",
        "description" => "The Beautiful photo gallery",
        "pic" => "images/gallery_1.jpg",
        "pic_preview" => "images/gallery_1.jpg",
        "photos" => array(
            array(
                "pic" => "images/gallery1_photo1.jpg",
                "pic_preview" => "images/gallery1_photo1.jpg",
            ),
            array(
                "pic" => "images/gallery1_photo2.jpg",
                "pic_preview" => "images/gallery1_photo2.jpg",
            ),
            array(
                "pic" => "images/gallery1_photo3.jpg",
                "pic_preview" => "images/gallery1_photo3.jpg",
            ),
        )
    );
    $result = Gallery_Add($item, array("LoadPictures"));
}

