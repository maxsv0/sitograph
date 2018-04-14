<?php


final class ModuleBlogTest extends MSVTestCase {

	public static function setUpBeforeClass() {
		$R = db_delete(TABLE_BLOG_ARTICLES); var_dump($R);
		db_delete(TABLE_STRUCTURE, "`url` = \"/blog/\"");
		db_delete(TABLE_MENU, "`url` = \"/blog/\"");
		msv_load_sitestructure();
	}

	public function testInstall() {
		global $website;

		$blogExists = false;
		foreach($website->structure as $structure) {
			if ($structure['url'] === $website->blog->baseUrl) {
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
		$this->assertContains($website->blog->baseUrl."?author=support@sitograph.com", $output);
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
		$this->assertNotContains($website->blog->baseUrl."?author=support@sitograph.com", $output);

		unset($_GET["author"]);
    }

    public function testCreateOutputArticlesSearch() {
		global $website;
        $_SERVER["REQUEST_URI"] = $website->blog->baseUrl."?s=Sitograph";
		$_GET["s"] = "Sitograph";
		$website->parseRequest();
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains("<span class=\"highlight\">Sitograph</span> CMS v.1.0 released", $output);
		$this->assertContains("Installing <span class=\"highlight\">Sitograph</span> CMS", $output);
		$this->assertContains("<span class=\"highlight\">Sitograph</span> CMS Screenshots", $output);

		unset($_GET["s"]);
    }

	public function testCreateOutputArticleDetails() {
		global $website;
		$_SERVER["REQUEST_URI"] = $website->blog->baseUrl."the-beautiful-photo-gallery-is-attached-to-this-post/";
		$website->parseRequest();
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains("<h1>The Beautiful photo gallery is attached to this post</h1>", $output);
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





