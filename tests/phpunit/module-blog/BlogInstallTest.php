<?php

final class BlogInstallTest extends MSVTestCase {
	public function testInstall() {
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

		Install_Blog($website->blog);

		$blogCreated = $this->checkIfStructureExists($website->blog->baseUrl);
		$this->assertTrue(
			$blogCreated,
			"Check that /blog/ structure was created"
		);
	}
}

