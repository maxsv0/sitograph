<?php

final class BlogAPITest extends MSVTestCase {

    public function testBlogAPIInfoPublic() {
        global $website;
        $website->setRequestUrl("/api/blog/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        $outputData = json_decode($output, true);
        $this->assertTrue($outputData["ok"]);
        $this->assertEquals(_t("msg.api.list_of_api"), $outputData["msg"]);
        $this->assertTrue(is_array($outputData["data"]));
        $this->assertEquals(3, count($outputData["data"]));
    }

    public function testBlogAPIInfoAdmin() {
        global $website;
        $website->setRequestUrl("/api/blog/");
        $tempAccess = $website->blog->accessAPIAdd;
        $tempAccess2 = $website->blog->accessAPIEdit;
        $website->blog->accessAPIAdd = "everyone";
        $website->blog->accessAPIEdit = "everyone";
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        $outputData = json_decode($output, true);
        $this->assertTrue($outputData["ok"]);
        $this->assertEquals(_t("msg.api.list_of_api"), $outputData["msg"]);
        $this->assertTrue(is_array($outputData["data"]));
        $this->assertEquals(5, count($outputData["data"]));

        // cleanup
        $website->blog->accessAPIAdd = $tempAccess;
        $website->blog->accessAPIEdit = $tempAccess2;
    }

    public function testBlogAPIWrongCall() {
		global $website;
		$website->setRequestUrl("/api/blog/".msv_generate_password()."/");
		$website->load();

		$output = msv_output_page();
		$this->printPage($output);

		$outputData = json_decode($output, true);
		$this->assertFalse($outputData["ok"]);
		$this->assertEquals(_t("msg.api.wrong_api"), $outputData["msg"]);
		$this->assertEmpty($outputData["data"]);
	}

	public function testBlogAPIList() {
		$articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);
		
        global $website;
        $website->setRequestUrl("/api/blog/list/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        $outputData = json_decode($output, true);
        $this->assertTrue($outputData["ok"]);
        $this->assertEmpty($outputData["msg"]);
        $this->assertTrue(is_array($outputData["data"]));
    }

	public function testBlogAPICategory() {
		$articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

		global $website;
		$website->setRequestUrl("/api/blog/category/");
		$website->load();

		$output = msv_output_page();
		$this->printPage($output);

		$outputData = json_decode($output, true);
		$this->assertTrue($outputData["ok"]);
		$this->assertEmpty($outputData["msg"]);
		$this->assertTrue(is_array($outputData["data"]));
	}

    public function testBlogAPIDetails() {
        $articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

        global $website;
		$website->setRequestUrl("/api/blog/details/".$articleData["data"]["id"]."/");
		$website->load();

		$output = msv_output_page();
		$this->printPage($output);

		$outputData = json_decode($output, true);
		$this->assertTrue($outputData["ok"]);
		$this->assertEmpty($outputData["msg"]);
		$this->assertTrue(is_array($outputData["data"]));
	}

    public function testBlogAPIAddArticleValid() {
        global $website;
        $data = array(
            "url" => msv_generate_password(),
            "title" => "title",
            "email" => "email",
            "sticked" => 1,
            "published" => 1,
            "views" => 12345,
            "shares" => 1234,
            "comments" => 123,
            "category" => array(
                array(
                    "url" => "art",
                    "title" => "Category Art"
                ),
                array(
                    "url" => "art/music",
                    "title" => "Music"
                ),
            )
        );
        $this->setRequestData($data);
        $website->blog->accessAPIAdd = "everyone";

        $website->setRequestUrl("/api/blog/add/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertTrue($outputData["ok"]);
        $this->assertEquals( _t("msg.blog.saved"), $outputData["msg"]);
        $this->assertNotEmpty($outputData["data"]);
        $this->assertEquals(1,$outputData["affected"]);

        // check data
        $this->assertEquals($data["published"],$outputData["data"]["published"]);
        $this->assertEquals($data["sticked"],$outputData["data"]["sticked"]);
        $this->assertEquals($data["url"],$outputData["data"]["url"]);
        $this->assertEquals($data["email"],$outputData["data"]["email"]);
        $this->assertEquals($data["title"],$outputData["data"]["title"]);
        $this->assertEquals($data["views"],$outputData["data"]["views"]);
        $this->assertEquals($data["shares"],$outputData["data"]["shares"]);
        $this->assertEquals($data["comments"],$outputData["data"]["comments"]);
        $this->assertEquals($data["album_id"],0);
        $this->assertEquals("api",$outputData["data"]["author"]);
        $this->assertEquals(1, $outputData["affected"]);
        $this->assertNotEmpty( $outputData["insert_id"]);
        $this->assertNotEmpty($outputData["data"]["id"]);
        $this->assertNotEmpty($outputData["data"]["id"]);

        // test part 2
        // load data from API and check
        /// TODO: fix this
        /// BLOG API doesn't create categories
//        $website->setRequestUrl("/api/blog/category/");
//        $website->load();
//
//        $output = msv_output_page();
//        $this->printPage($output);
//
//        $outputData = json_decode($output, true);
//        $this->assertTrue($outputData["ok"]);
//        $this->assertEmpty($outputData["msg"]);
//        $this->assertTrue(is_array($outputData["data"]));

        // clean
        $this->unsetRequestData($data);
    }

    //
    // TEST API Errors handling:
    //
	public function testBlogAPIDetails404() {
		global $website;
		$randomStr = md5(time());
		$website->setRequestUrl("/api/blog/details/".$randomStr."/");
		$website->load();

		$output = msv_output_page();
		$this->printPage($output);

        // check JSON data
		$outputData = json_decode($output, true);
		$this->assertTrue($outputData["ok"]);
		$this->assertNotEmpty($outputData["msg"]);
		$this->assertEmpty($outputData["data"]);
	}

    public function testBlogAPIEditValid() {
        $articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

        global $website;
        $accessLevel = $website->blog->accessAPIEdit;
        $website->blog->accessAPIEdit = "everyone";

        $_REQUEST["updateName"] = "title";
        $_REQUEST["updateID"] = $articleData["data"]["id"];
        $_REQUEST["updateValue"] = msv_generate_password();

        $website->setRequestUrl("/api/blog/edit/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertTrue($outputData["ok"]);
        $this->assertContains("Success", $outputData["msg"]);
        $this->assertNotEmpty($outputData["data"]);

        // try to get this article
        $outputData = db_get_count(TABLE_BLOG_ARTICLES, "`title` like '".$_REQUEST["updateValue"]."'");
        $this->assertTrue($outputData["ok"]);
        $this->assertContains("Success", $outputData["msg"]);
        $this->assertNotEmpty($outputData["data"]);
        $this->assertEquals(1, $outputData["affected"]);
        $this->assertEquals(0, $outputData["insert_id"]);

        // cleanup
        $website->blog->accessAPIEdit = $accessLevel;
    }

    public function testBlogAPIEditWrongCall() {
        global $website;
        $accessLevel = $website->blog->accessAPIEdit;
        $website->blog->accessAPIEdit = "everyone";

        unset($_REQUEST["updateName"]);

        $website->setRequestUrl("/api/blog/edit/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals(_t("msg.api.wrong_api"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // cleanup
        $website->blog->accessAPIEdit = $accessLevel;
    }

/*
 * 	disable cause of a email notification
 *
 * 	public function testBlogAPIAddArticleNoEmail() {
        global $website;
	    $data = array(
	        "title" => "title",
	        "url" => msv_generate_password(),
        );
	    $this->setRequestData($data);
        $website->blog->accessAPIAdd = "everyone";

        $website->setRequestUrl("/api/blog/add/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals( _t("msg.blog.noemail"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // clean
        $this->unsetRequestData($data);
    }
*/

	public function testBlogAPIAddArticleNoUrl() {
        global $website;
	    $data = array(
	        "title" => "title",
        );
	    $this->setRequestData($data);
        $website->blog->accessAPIAdd = "everyone";

        $website->setRequestUrl("/api/blog/add/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals( _t("msg.blog.nourl"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // clean
        $this->unsetRequestData($data);
    }

	public function testBlogAPIAddArticleNoTitle() {
        global $website;
	    $data = array(
            "url" => msv_generate_password(),
        );
	    $this->setRequestData($data);
        $website->blog->accessAPIAdd = "everyone";

        $website->setRequestUrl("/api/blog/add/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals( _t("msg.blog.notitle"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // clean
        $this->unsetRequestData($data);
    }

    //
    // TEST NO ACCESS
    //
    public function testBlogAPIAddNoAccess() {
        global $website;
        $data = array(
            "url" => msv_generate_password(),
            "title" => "title",
            "email" => "email",
        );
        $this->setRequestData($data);
        $accessLevel = $website->blog->accessAPIAdd;
        $website->blog->accessAPIAdd = "noaccess";

        $website->setRequestUrl("/api/blog/add/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals( _t("msg.api.no_access"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // clean
        $this->unsetRequestData($data);
        $website->blog->accessAPIAdd = $accessLevel;
    }

    public function testBlogAPIListNoAccess() {
        global $website;
        $accessLevel = $website->blog->accessAPIList;
        $website->blog->accessAPIList = "noaccess";

        $website->setRequestUrl("/api/blog/list/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals( _t("msg.api.no_access"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // cleanup
        $website->blog->accessAPIList = $accessLevel;
    }


    public function testBlogAPICategoryNoAccess() {
        global $website;
        $accessLevel = $website->blog->accessAPICategory;
        $website->blog->accessAPICategory = "noaccess";

        $website->setRequestUrl("/api/blog/category/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals( _t("msg.api.no_access"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // cleanup
        $website->blog->accessAPICategory = $accessLevel;
    }

    public function testBlogAPIDetailsNoAccess() {
        global $website;
        $accessLevel = $website->blog->accessAPIDetails;
        $website->blog->accessAPIDetails = "noaccess";

        $website->setRequestUrl("/api/blog/details/123/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals( _t("msg.api.no_access"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // cleanup
        $website->blog->accessAPIDetails = $accessLevel;
    }

    public function testBlogAPIEditNoAccess() {
        global $website;
        $accessLevel = $website->blog->accessAPIEdit;
        $website->blog->accessAPIEdit = "noaccess";

        $website->setRequestUrl("/api/blog/edit/123/");
        $website->load();

        $output = msv_output_page();
        $this->printPage($output);

        // check JSON data
        $outputData = json_decode($output, true);
        $this->assertFalse($outputData["ok"]);
        $this->assertEquals(_t("msg.api.no_access"), $outputData["msg"]);
        $this->assertEmpty($outputData["data"]);

        // cleanup
        $website->blog->accessAPIEdit = $accessLevel;
    }
}

