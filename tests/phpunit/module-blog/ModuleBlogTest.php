<?php
use PHPUnit\Framework\TestCase;

final class ModuleBlogTest extends TestCase {
    public function testCreateDefaultOutput() {
        $website = msv_get();
        $_SERVER["REQUEST_URI"] = "/blog/";
        $website->parseRequest();

        msv_start();
        msv_load();
        $output = msv_output_page();

        $this->assertNotEmpty($output);
        // TODO: assert HTML
    }
}





