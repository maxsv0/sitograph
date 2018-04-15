<?php
use PHPUnit\Framework\TestCase;

class MSVTestCase extends TestCase {
	public function loadPageDOM($string) {
		$doc = new DOMDocument();
		$doc->loadHTML($string);
		return $doc;
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
