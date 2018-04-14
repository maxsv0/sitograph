<?php


final class ModuleBlogTest extends MSVTestCase {

	public static function setUpBeforeClass() {
        db_delete(TABLE_BLOG_ARTICLES);
        db_delete(TABLE_STRUCTURE, "`url` like \"/blog/\"");
        db_delete(TABLE_MENU, "`url` like \"/blog/\"");

        msv_load_sitestructure();
	}

	public function testInstall() {
		global $website;

		$blogExists = false;
		foreach($website->structure as $structure) {
			if ($structure['url'] === $website->blog->baseUrl && $structure['deleted'] == 0) {
				$blogExists = true;
			}
		}
		$this->assertFalse(
			$blogExists,
			"Check that /blog/ structure doesn't exists before test execution"
		);

		Install_Blog($website->blog);
		msv_load_sitestructure();

		$blogCreated = false;
		foreach($website->structure as $structure) {
			if ($structure['url'] === $website->blog->baseUrl) {
				$blogCreated = true;
			}
		}
		$this->assertTrue(
			$blogCreated,
			"Check that /blog/ structure was created"
		);
	}

	public function testCreateDefaultOutput() {
		global $website;
		$_SERVER["REQUEST_URI"] = $website->blog->baseUrl;
		$website->parseRequest();
		$website->load();
		$output = $website->outputPage();
		$this->assertNotEmpty($output);

		// check default website content
		$this->assertContains($website->blog->baseUrl."?author=tech@sitograph.com", $output);
		$this->assertContains($website->blog->baseUrl."?author=cyhiso", $output);
	}



    public function testCreateOutputArticlesByAuthor() {
		global $website;
        $_SERVER["REQUEST_URI"] = $website->blog->baseUrl."?author=tech@sitograph.com";
        $_GET["author"] = "tech@sitograph.com";
		$website->parseRequest();
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains($website->blog->baseUrl."?author=tech@sitograph.com", $output);
		$this->assertNotContains($website->blog->baseUrl."?author=cyhiso", $output);

		unset($_GET["author"]);
    }

    public function testCreateOutputArticlesSearch() {
		global $website;
        $_SERVER["REQUEST_URI"] = $website->blog->baseUrl."?s="._t("blog.post1");
		$_GET["s"] = _t("blog.post1");
		$website->parseRequest();
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains("<span class=\"highlight\">"._t("blog.post1")."</span>", $output);

		unset($_GET["s"]);
    }

	public function testCreateOutputArticleDetails() {
		global $website;
		$_SERVER["REQUEST_URI"] = $website->blog->baseUrl."the-beautiful-photo-gallery-is-attached-to-this-post/";
		$website->parseRequest();
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains("<h1>"._t("blog.post2")."</h1>", $output);
	}

    /*
     *
     * https://github.com/maxsv0/sitograph/issues/143
     *
     */
    public function testCreateOutputArticles404() {
		global $website;
        $randomStr = md5(date());
        $_SERVER["REQUEST_URI"] = $website->blog->baseUrl.$randomStr."/";
		$website->parseRequest();
		$website->load();

        $output = msv_output_page();
        $this->assertNotEmpty($output);
    }


}





