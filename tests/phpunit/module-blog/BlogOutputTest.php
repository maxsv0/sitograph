<?php

final class BlogOutputTest extends MSVTestCase {
	/*
	 *
	 * Run this procedure before other tests
	 * setup MSV website instance to use /blog/ URL
	 *
	 * */
	public static function setUpBeforeClass() {
		global $website;
		$website->setRequestUrl($website->blog->baseUrl);
	}

	public function testCreateDefaultOutput() {
		global $website;
		$website->load();
		$output = $website->outputPage();
		$this->assertNotEmpty($output);

		// check default website content
		$this->assertContains(
			$website->blog->baseUrl."?author=tech@sitograph.com",
			$output
		);
		$this->assertContains(
			$website->blog->baseUrl."?author=cyhiso",
			$output
		);
	}

    public function testCreateOutputArticlesByAuthor() {
		global $website;
        $_GET["author"] = "tech@sitograph.com";
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains(
			$website->blog->baseUrl."?author=tech@sitograph.com",
			$output
		);
		$this->assertNotContains(
			$website->blog->baseUrl."?author=cyhiso",
			$output
		);

		unset($_GET["author"]);
    }

    public function testCreateOutputArticlesSearch() {
		global $website;
		$_GET["s"] = _t("blog.post1");
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains(
			"<span class=\"highlight\">"._t("blog.post1")."</span>",
			$output
		);

		unset($_GET["s"]);
    }

	public function testCreateOutputArticleDetails() {
		global $website;
		$website->setRequestUrl(
			$website->blog->baseUrl."the-beautiful-photo-gallery-is-attached-to-this-post/"
		);
		$website->load();
		$output = $website->outputPage();

		// check default website content
		$this->assertContains(
			"<h1>"._t("blog.post2")."</h1>",
			$output
		);
	}

    /*
     *
     * https://github.com/maxsv0/sitograph/issues/143
     *
     */
    public function testCreateOutputArticles404() {
		global $website;
        $randomStr = md5(date());
		$website->setRequestUrl(
			$website->blog->baseUrl.$randomStr."/"
		);
		$website->load();

        $output = msv_output_page();
        $this->assertNotEmpty($output);
    }

	public function testAPIListArticles() {
		global $website;
		$website->setRequestUrl(
			"/api/blog/list/"
		);
		$website->load();

		$output = msv_output_page();
		$this->assertNotEmpty($output);

		$outputData = json_decode($output, true);
		$this->assertTrue($outputData["ok"]);
		$this->assertEmpty($outputData["msg"]);
		$this->assertTrue(is_array($outputData["data"]));
	}

}





