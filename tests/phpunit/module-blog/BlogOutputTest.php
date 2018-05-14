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

	public function testBlogOutputDefault() {
	    $articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

		global $website;
		$website->load();
		$output = $website->outputPage();
        $this->printPage($output);

		// check default website content
		$this->assertContains(
			$website->blog->baseUrl."?author=tech@sitograph.com",
			$output
		);
		$this->assertContains(
			$website->blog->baseUrl."?author=cyhiso",
			$output
		);
		$this->assertContains(
            $articleData["data"]["url"],
			$output
		);
	}

    public function testBlogOutputArticlesByAuthor() {
		global $website;
        $_GET[$website->blog->authorUrlParam] = "tech@sitograph.com";
		$website->load();
		$output = $website->outputPage();
        $this->printPage($output);

		// check default website content
		$this->assertContains(
			$website->blog->baseUrl."?author=tech@sitograph.com",
			$output
		);
		$this->assertNotContains(
			$website->blog->baseUrl."?author=cyhiso",
			$output
		);

		unset($_GET[$website->blog->authorUrlParam]);
    }

    public function testBlogOutputArticlesByCategory() {
        $articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

        global $website;
        $_GET[$website->blog->categoryUrlParam] = "art";
        $website->load();
        $output = $website->outputPage();
        $this->printPage($output);

        // check website content
        $this->assertContains(
            $articleData["data"]["url"],
            $output
        );
        // TODO: add proper asserts

        unset($_GET[$website->blog->categoryUrlParam]);
    }

    public function testBlogOutputArticlesBySubCategory() {
        $articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

		global $website;
        $_GET[$website->blog->categoryUrlParam] = "art/music";
		$website->load();
		$output = $website->outputPage();
        $this->printPage($output);

		// check website content
        $this->assertContains(
            $articleData["data"]["url"],
            $output
        );
		// TODO: add proper asserts

		unset($_GET[$website->blog->categoryUrlParam]);
    }

    public function testBlogOutputArticlesByAllCategory() {
        $articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

		global $website;
        $_GET[$website->blog->categoryUrlParam] = "%";
		$website->load();
		$output = $website->outputPage();
        $this->printPage($output);

		// check website content
        $this->assertContains(
            $articleData["data"]["url"],
            $output
        );

		unset($_GET[$website->blog->categoryUrlParam]);
    }

    public function testBlogOutputArticlesSearch() {
        $articleData = blogAddTestData();
        $this->assertTrue($articleData["ok"], $articleData["msg"]);

        $tmp = explode(" ", $articleData["data"]["title"]);
        $keyword = $tmp[count($tmp)-1];

		global $website;
		$_GET[$website->blog->searchUrlParam] = $keyword;
		$website->load();
		$output = $website->outputPage();
        $this->printPage($output);

		// check default website content
		$this->assertContains(
			"<span class=\"highlight\">".$keyword."</span>",
			$output
		);

		unset($_GET[$website->blog->searchUrlParam]);
    }

    public function testBlogOutputArticlesSearchError() {
		global $website;
		$tempValue = $website->blog->itemsPerPage;
		$website->blog->itemsPerPage = -1;

		$website->load();
		$output = $website->outputPage();
        $this->printPage($output);

        // TODO: fix this!
		// output contains some articles?
		// this is definitely output from some other test

		$website->blog->itemsPerPage = $tempValue;
		unset($_GET[$website->blog->searchUrlParam]);
    }

	public function testBlogOutputArticleDetailsDefault() {
		global $website;
		$website->setRequestUrl(
			$website->blog->baseUrl."the-beautiful-photo-gallery-is-attached-to-this-post/"
		);
		$website->load();
		$output = $website->outputPage();
        $this->printPage($output);

		// check default website content
		$this->assertContains(
			"<h1>"._t("blog.post2")."</h1>",
			$output
		);
	}

    public function testBlogOutputArticleDetailsRandom() {
        $articleData = blogAddTestData();
		$this->assertTrue($articleData["ok"], $articleData["msg"]);

        global $website;
        $website->setRequestUrl(
            $website->blog->baseUrl.$articleData["data"]["url"]."/"
        );
        $website->load();
        $output = $website->outputPage();
        $this->printPage($output);

        // check default website content
        $this->assertContains(
            "<h1>".$articleData["data"]["title"]."</h1>",
            $output
        );
    }

    /*
     *
     * https://github.com/maxsv0/sitograph/issues/143
     *
     */
    public function testBlogOutputArticle404() {
		global $website;
		$website->setRequestUrl(
			$website->blog->baseUrl.msv_generate_password()."/"
		);
		$website->loadPage($website->blog->baseUrl);
		$website->load();

        $output = msv_output_page();
        $this->printPage($output);

        $this->assertContains("404", $output);
    }
}





