<?php

final class ConfigTest extends MSVTestCase {

	public function testLoad() {
		// Load MSV Website
		include("index.php");

		// check config.php constants:
		$this->assertTrue(defined("LANGUAGES"));
		$this->assertTrue(defined("DB_HOST"));
		$this->assertTrue(defined("DB_LOGIN"));
		$this->assertTrue(defined("DB_PASSWORD"));
		$this->assertTrue(defined("DB_NAME"));
		$this->assertTrue(defined("ABS"));
		$this->assertTrue(defined("DB_REQUIRED"));
		$this->assertTrue(defined("DATE_FORMAT"));
		$this->assertTrue(defined("PROTOCOL"));
		$this->assertTrue(defined("MASTERHOST"));
		$this->assertTrue(defined("UPLOAD_FILES_PATH"));
		$this->assertTrue(defined("CONTENT_URL"));
		$this->assertTrue(defined("PHP_HIDE_ERRORS"));
		$this->assertTrue(defined("DEBUG"));
		$this->assertTrue(defined("DEBUG_LOG"));
		$this->assertTrue(defined("SITE_CLOSED"));
		$this->assertTrue(defined("SHOW_ADMIN_MENU"));
		$this->assertTrue(defined("PHP_LOCALE"));
		$this->assertTrue(defined("PHP_TIMEZONE"));
		$this->assertTrue(defined("DATABASE_ENCODING"));
		$this->assertTrue(defined("JS_BEFORE_BODY"));
		$this->assertTrue(defined("SUBDOMAIN_LANGUAGES"));
		$this->assertTrue(defined("REP"));
		$this->assertTrue(defined("USER_HASH_PASSWORD"));
		$this->assertTrue(defined("USER_IGNORE_PRIVILEGES"));
		$this->assertTrue(defined("SMARTY_DIR"));

		// check env settings:
		$this->assertTrue(defined("MSV_INSTALED"));
		$this->assertTrue(MSV_INSTALED);
		$this->assertTrue(defined("ABS_INCLUDE"));
		$this->assertTrue(defined("ABS_MODULE"));
		$this->assertTrue(defined("ABS_CUSTOM"));
		$this->assertTrue(defined("ABS_TEMPLATE"));
		$this->assertTrue(defined("LOCAL_INCLUDE"));
		$this->assertTrue(defined("LOCAL_MODULE"));
		$this->assertTrue(defined("LOCAL_TEMPLATE"));

		$website = msv_get();
		$this->assertInstanceOf(
			MSV_Website::class,
			$website
		);
	}
}
