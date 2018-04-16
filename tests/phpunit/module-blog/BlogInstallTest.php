<?php

final class BlogInstallTest extends MSVTestCase {
	public function testBlogInstallHook() {
		global $website;

		//cleanup
		db_delete(TABLE_BLOG_ARTICLES);
		db_delete(TABLE_STRUCTURE, "`url` like \"/blog/\"");
		db_delete(TABLE_MENU, "`url` like \"/blog/\"");

		$blogExists = $this->checkIfStructureExists($website->blog->baseUrl);
		$this->assertFalse(
			$blogExists,
			"Check that /blog/ structure doesn't exists before test execution"
		);

		$website->blog->runInstallHook();

		$blogCreated = $this->checkIfStructureExists($website->blog->baseUrl);
		$this->assertTrue(
			$blogCreated,
			"Check that /blog/ structure was created"
		);

		// TODO:
        // check ALL installed data

        // TODO:
        // cleanup
	}
}

