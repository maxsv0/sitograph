<?php
use PHPUnit\Framework\TestCase;

class MSVTestCase extends TestCase {
//	public function loadPageDOM($string) {
//		$doc = new DOMDocument();
//		$doc->loadHTML($string);
//		return $doc;
//	}

    public function printPage($output) {
        $this->assertNotEmpty($output);

        echo "-------------------------- Page output ----------------------- \n";
        echo $output;
        echo "\n\n\n";
    }

	public function setRequestData($dataList) {
        foreach ($dataList as $k => $v) {
            $_REQUEST[$k] = $v;
            $_GET[$k] = $v;
            $_POST[$k] = $v;
        }
    }

	public function unsetRequestData($dataList) {
        foreach ($dataList as $k => $v) {
            unset($_REQUEST[$k]);
            unset($_GET[$k]);
            unset($_POST[$k]);
        }
    }

	public function checkIfStructureExists($url) {
		msv_load_sitestructure();
		$structureList = msv_get("website.structure");

		$blogExists = false;
		foreach($structureList as $structure) {
			if ($structure['url'] === $url && $structure['deleted'] == 0) {
				$blogExists = true;
			}
		}

		return $blogExists;
	}
}
