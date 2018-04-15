<?php

final class BlogAPITest extends MSVTestCase {
	private $articleId = 0;

	public function testAPIWrongCall() {
		global $website;
		$randomStr = md5(date());
		$website->setRequestUrl("/api/blog/".$randomStr."/");
		$website->load();

		$output = msv_output_page();
		$this->assertNotEmpty($output);

		$outputData = json_decode($output, true);
		$this->assertFalse($outputData["ok"]);
		$this->assertNotEmpty($outputData["msg"]);
		$this->assertEmpty($outputData["data"]);
	}

	// TODO: slit into 2 tests.
	// don't know why  @depends testAPIListArticles doesn't work
	public function testAPIListArticlesAndDetails() {
		global $website;
		$website->setRequestUrl("/api/blog/list/");
		$website->load();

		$output = msv_output_page();
		$this->assertNotEmpty($output);

		$outputData = json_decode($output, true);
		$this->assertTrue($outputData["ok"]);
		$this->assertEmpty($outputData["msg"]);
		$this->assertTrue(is_array($outputData["data"]));

		$article = reset($outputData["data"]);
		$this->articleId = $article["id"];

		$this->assertNotEmpty($this->articleId);

		// start test part 2
		$website->setRequestUrl("/api/blog/details/".$this->articleId."/");
		$website->load();

		$output = msv_output_page();
		$this->assertNotEmpty($output);

		$outputData = json_decode($output, true);
		$this->assertTrue($outputData["ok"]);
		$this->assertEmpty($outputData["msg"]);
		$this->assertTrue(is_array($outputData["data"]));
	}

	public function testAPIDetails404() {
		global $website;
		$randomStr = md5(date());
		$website->setRequestUrl("/api/blog/details/".$randomStr."/");
		$website->load();

		$output = msv_output_page();
		$this->assertNotEmpty($output);

		$outputData = json_decode($output, true);
		$this->assertTrue($outputData["ok"]);
		$this->assertNotEmpty($outputData["msg"]);
		$this->assertEmpty($outputData["data"]);
	}
}





