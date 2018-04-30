<?php

final class MSVWebsiteClass extends MSVTestCase {

    public function testMSVWebsiteInit() {

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

    public function testMSVWebsiteParseRequest() {
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
            echo "Testing: ".$testUrl["request"];
            $_SERVER["REQUEST_URI"] = $testUrl["request"];
            $website->parseRequest();

            // TODO: fix this assert.
			// Why requestUrlRaw same as requestUrl?
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
            echo " .. done\n";
        }
    }

    public function testMSVWebsiteCheckAccess() {
        $website = msv_get();

        $accessList = array(
            // List of test data
            // page access,  user access, expected result
            array("everyone", "unknown", true),
            array("everyone", "anonymous", true),
            array("everyone", "user", true),
            array("everyone", "admin", true),
            array("everyone", "dev", true),

            array("user", "unknown", false),
            array("user", "anonymous", false),
            array("user", "user", true),
            array("user", "admin", true),
            array("user", "dev", true),

            array("admin", "unknown", false),
            array("admin", "anonymous", false),
            array("admin", "user", false),
            array("admin", "admin", true),
            array("admin", "dev", true),

            array("dev", "unknown", false),
            array("dev", "anonymous", false),
            array("dev", "user", false),
            array("dev", "admin", false),
            array("dev", "dev", true),
        );

        foreach ($accessList as $accessTemplate) {
            list($page, $user, $result) = $accessTemplate;
            echo "Access: page=$page, user=$user => ".(int)$result."\n";

            if ($result) {
                $this->assertTrue($website->checkAccess($page, $user));
            } else {
                $this->assertFalse($website->checkAccess($page, $user));
            }
        }

        $tempValue = $website->instaled;

        $website->instaled = false;
        foreach ($accessList as $accessTemplate) {
            list($page, $user, ) = $accessTemplate;

            $this->assertTrue($website->checkAccess($page, $user));
        }

        $website->instaled = $tempValue;
	}


    public function testMSVWebsiteOutputDefault() {
        msv_start();
        msv_load();
        $output = msv_output_page();
        $this->printPage($output);
	}

/*
// TODO: use set_exit_overload

	Jenkins doesn't support skipped tests
	to just comment

	public function testMSVWebsiteOutputError() {
        $this->markTestSkipped('Need to rewrite a test to use set_exit_overload');

        $website = msv_get();
        set_exit_overload(function() { return false; });

        ob_start();
		$website->outputError("test message");
		$output = ob_get_contents();
		ob_end_flush();

        $this->assertContains("test message",$output);
        $this->assertContains("ERROR",$output);
        unset_exit_overload();
	}
*/

    public function testMSVWebsiteOutputForbidden() {
        $website = msv_get();

        ob_start();
		$website->outputForbidden();
		$output = ob_get_contents();
		ob_end_flush();
        $this->assertEmpty($output);
	}

    public function testMSVWebsiteOutputRedirect() {
        $website = msv_get();

        ob_start();
		$website->outputRedirect("/test/");
		$output = ob_get_contents();
		ob_end_flush();
		$this->assertContains("/test/",$output);
	}

    public function testMSVWebsiteOutput404() {
        $website = msv_get();

        ob_start();
		$website->outputNotFound();
		$output = ob_get_contents();
		ob_end_flush();
		$this->assertContains("Page not found.",$output);
	}

    public function testMSVWebsiteOutputDebug() {
        $website = msv_get();

		$website->outputDebug();
		$this->printPage($website->config["debug_code"]);
	}
}