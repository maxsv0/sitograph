<?php

function blogAddTestData() {
    $data = array(
        "url" => msv_generate_password(),
        "title" => "Blog Test Title ".msv_generate_password(),
        "email" => "email",
        "sticked" => 1,
        "published" => 1,
        "date" => "2018-01-01 14:47:32",
        "views" => rand(10000,100000),
        "shares" => rand(100,1000),
        "comments" => rand(10,100),
        "category" => array(
            array(
                "url" => "art",
                "title" => "Category Art"
            ),
            array(
                "url" => "art/music",
                "title" => "Music"
            ),
            array(
                "url" => "art/music",
                "title" => "Music"
            ),
        )
    );

    return api_blog_add($data);
}
