<?php
use PHPUnit\Framework\TestCase;

final class MSVWebsiteClass extends MSVTestCase {
    public function testCreateMSVClassInstance() {

        $website = msv_get();
        $this->assertInstanceOf(
            MSV_Website::class,
            $website
        );
    }

    public function testMSVClassInit() {
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
        $this->assertTrue(defined("ABS_INCLUDE"));
        $this->assertTrue(defined("ABS_MODULE"));
        $this->assertTrue(defined("ABS_CUSTOM"));
        $this->assertTrue(defined("ABS_TEMPLATE"));
        $this->assertTrue(defined("LOCAL_INCLUDE"));
        $this->assertTrue(defined("LOCAL_MODULE"));
        $this->assertTrue(defined("LOCAL_TEMPLATE"));

        // check MSV settings:
        $this->assertTrue(defined("HOST"));
        $this->assertTrue(defined("LANG"));
        $this->assertTrue(defined("LANG_URL"));
        $this->assertTrue(defined("HOME_URL"));
        $this->assertTrue(defined("HOME_LINK"));

        // get MSV Website object
        $website = msv_get();

        // check MSV Website defaults
        $this->assertNotEmpty($website->log);
        $this->assertFalse($website->langSubdomain);
        $this->assertNotEmpty($website->lang);
        $this->assertNotEmpty($website->langDefault);
        $this->assertEmpty($website->langUrl);
        $this->assertNotEmpty($website->host);
        $this->assertNotEmpty($website->masterhost);
        $this->assertNotEmpty($website->protocol);
        $this->assertEquals(DEBUG,$website->debug);

        $this->assertEquals(HOME_LINK,$website->protocol.$website->masterhost);
        $this->assertEquals(HOME_URL,HOME_LINK."/");
        $this->assertArraySubset(array($website->langDefault), $website->languages);
        $this->assertArraySubset(array($website->lang), $website->languages);

        // check MSV Website default config
        $this->assertNotEmpty($website->config["db"]);
        $this->assertEquals(HOME_URL,HOME_LINK."/");
        $this->assertArrayHasKey($website->lang,$website->config["home"]);
        $this->assertArrayHasKey($website->langDefault,$website->config["home"]);
        $this->assertEquals(HOME_URL,$website->config["home_url"]);
        $this->assertEquals($website->languages,$website->config["languages"]);
        $this->assertEquals("testreferer",$website->config["referer"]);
    }

    public function testMSVClassParseRequest() {
        $listTestUrl = array(
            array(
                "request" => "/some_random_url/",
                "result" => "/some_random_url/",
                "hasTrailingSlash" => true,
            ),
            array(
                "request" => "/some_random_url/with_second_level/",
                "result" => "/some_random_url/with_second_level/",
                "hasTrailingSlash" => true,
            ),
            array(
                "request" => "/some_random_url/with_second_level/",
                "result" => "/some_random_url/with_second_level/",
                "hasTrailingSlash" => true,
            ),
            array(
                "request" => "/some_random_url/with_second_level/?some_value#anchor",
                "result" => "/some_random_url/with_second_level/",
                "hasTrailingSlash" => true,
            ),
            array(
                "request" => "/some_random_url/with_second_level/?some_value=1&extra_param=1#anchor",
                "result" => "/some_random_url/with_second_level/",
                "hasTrailingSlash" => true,
            ),
            array(
                "request" => "/some_random_url",
                "result" => "/some_random_url",
                "hasTrailingSlash" => false,
            ),
            array(
                "request" => "/some_random_url/with_level_two",
                "result" => "/some_random_url/with_level_two",
                "hasTrailingSlash" => false,
            ),
            array(
                "request" => "/some_random_url/with_level_two?some_params",
                "result" => "/some_random_url/with_level_two",
                "hasTrailingSlash" => false,
            ),
            array(
                "request" => "/some_random_url/with_level_two?some_params=1&extra_param=1",
                "result" => "/some_random_url/with_level_two",
                "hasTrailingSlash" => false,
            ),
        );

        $website = msv_get();
        foreach ($listTestUrl as $testUrl) {
            $_SERVER["REQUEST_URI"] = $testUrl["request"];
            $website->parseRequest();
            $this->assertEquals(
                $testUrl["result"],
                $website->requestUrlRaw
            );
            $this->assertEquals(
                $testUrl["result"],
                $website->requestUrl
            );
            $this->assertEquals(
                $testUrl["hasTrailingSlash"],
                $website->config["hasTrailingSlash"]
            );
        }
    }

    public function testCreateMSVWebsiteStartDefault() {
        msv_start();
        msv_load();
        $output = msv_output_page();
        $this->assertNotEmpty($output);
	}
}





