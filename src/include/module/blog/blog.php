<?php
function BlogLoadPreview($blog) {
	 $resultQuery = API_getDBList(TABLE_BLOG_ARTICLES, "", "`views` desc, `date` desc", $blog->previewItemsCount, "");
	 if ($resultQuery["ok"]) {
		// get a list of albums from API result
		$listItems = $resultQuery["data"];
	
		// assign data to template
		MSV_assignData("blog_articles_topviews", $listItems);
	}
	
	$resultQuery = API_getDBList(TABLE_BLOG_ARTICLES, "", "`date` desc", $blog->newestItemsCount, "");
	if ($resultQuery["ok"]) {
		// get a list of albums from API result
		$listItems = $resultQuery["data"];
	
		// assign data to template
		MSV_assignData("blog_articles_newest", $listItems);
	}
	
}


function BlogLoadArticles($blog) {
	
	// ************ sql filter ************
	$sqlFilter = " 1 = 1 ";
	
    if (!empty($_GET[$blog->searchUrlParam])) {
    	$arSearch = array("title", "description", "text");
    	$sn = MSV_SQLEscape($_GET[$blog->searchUrlParam]);

    	$sqlFilter .= " and ( ";
    	foreach ($arSearch as $v) {
    		$sqlFilter .= "$v like '%$sn%' or ";
    	}
    	$sqlFilter = substr($sqlFilter, 0, -3).") ";
    }
    if (!empty($_GET[$blog->authorUrlParam])) {
    	$sn = MSV_SQLEscape($_GET[$blog->authorUrlParam]);
    	$sqlFilter .= " and author like '$sn' ";
    }
    // ************************************
    
    // Load list of albums
    $category = $_GET[$blog->categoryUrlParam];
    
    if (!empty($category)) {
    	$section = $subsection = "";
    	
    	if (preg_match("/^([-a-zA-Z0-9]+)\/([-a-zA-Z0-9]+)$/", $category)) {
    		$sn = MSV_SQLEscape($category);
    		
    		list($section, $subsection) = explode("/", $category);
    		
    	} elseif (preg_match("/^[-a-zA-Z0-9]+$/", $category)) {
    		$sn = MSV_SQLEscape($category."/%");
    		
    		$section = $category;
    	} else {
    		$sn = "-";
    	}
    	
    	// add item to page nativation line
    	if (!empty($section)) {
    		$sectionUrl = $blog->baseUrl."?category=$section";
    		
    		$navQuery = API_getDBItem(TABLE_BLOG_ARTICLE_CATEGORIES, " url = '".$section."/".$section."'");
			if ($navQuery["ok"]) {
				$categoryRow = $navQuery["data"];
				MSV_setNavigation($categoryRow["title"], $sectionUrl);
			} 
    	}
    	
    	if (!empty($subsection)) {
    		$navQuery = API_getDBItem(TABLE_BLOG_ARTICLE_CATEGORIES, " url = '".$category."'");
			if ($navQuery["ok"]) {
				$categoryRow = $navQuery["data"];
				MSV_setNavigation($categoryRow["title"]);
			} 
    	}
			
    	$resultCategories = API_getDBList(TABLE_BLOG_ARTICLE_CATEGORIES, " `url` like '".$sn."' ", "`article_id`");
    	if ($resultCategories["ok"]) {
    		$listItemsID = array();
			foreach ($resultCategories["data"] as $item) {
				$listItemsID[] = $item["article_id"];
			}
    		$sqlFilter .= " and `id` IN (".implode(",",$listItemsID).") ";
		}
    }
  	
    $resultQuery = API_getDBListPaged(TABLE_BLOG_ARTICLES, $sqlFilter, "`date` desc", $blog->itemsPerPage, $blog->pageUrlParam);
    
	// Display message in case of error
	if (!$resultQuery["ok"]) {
		API_callError($resultQuery["msg"]);
		return false;
	} 
	
	// get a list of albums from API result
	$listItems = $resultQuery["data"];
	
	// get a list of pages from API result
	$listPages = $resultQuery["pages"];
	
	if (!empty($listItems)) {
		// create list if articles ID
		$listItemsID = array_keys($listItems);
		
		// Load categories for article
		$resultCategories = API_getDBList(TABLE_BLOG_ARTICLE_CATEGORIES, " `article_id` IN (".implode(",",$listItemsID).")", "`url`");
		if ($resultCategories["ok"]) {
			
			foreach ($resultCategories["data"] as $item) {
				list($section, $category) = explode("/", $item["url"]);
				$articleID = (int)$item["article_id"];
				
				if (empty($listItems[$articleID]["categories"])) {
					$listItems[$articleID]["categories"] = array();
				}
				if (empty($listItems[$articleID]["sections"])) {
					$listItems[$articleID]["sections"] = array();
				}
			
				if (!in_array($section, $listItems[$articleID]["sections"])) {
					$sectionItem = $item;
					$sectionItem["url"] = $section;
					$sectionItem["title"] = ucfirst($section);
					$listItems[$articleID]["sections"][$section] = $sectionItem;
				}
				$listItems[$articleID]["categories"][] = $item;
			}
			
		}
	}
	
	// assign data to template
	MSV_assignData("blog_articles", $listItems);
	MSV_assignData("blog_pages", $listPages);
}

function BlogLoadArticleDetails($blog) {
	
	$articleUrl = $blog->website->requestUrlMatch[1];
	if (empty($articleUrl)) {
		MSV_Output404();
	}

	$resultQuery = API_getDBItem(TABLE_BLOG_ARTICLES, " url = '".$articleUrl."'");
	if (!$resultQuery["ok"]) {
		MSV_MessageError($resultQuery["msg"]);
		return false;
	} 
	$article = $resultQuery["data"];

	//exit if no articles where found
	if (empty($article)) {
		MSV_Output404();
	}
	
	// Load categories for article
	$resultCategories = API_getDBList(TABLE_BLOG_ARTICLE_CATEGORIES, " `article_id` = ".$article["id"]."", "`url`");
	if ($resultCategories["ok"]) {
		
		$article["sections"] = array();
		$article["categories"] = array();
		
		foreach ($resultCategories["data"] as $item) {
			list($section, $category) = explode("/", $item["url"]);
			
			if (!in_array($section, $article["sections"])) {
				$sectionItem = $item;
				$sectionItem["url"] = $section;
				$sectionItem["title"] = ucfirst($section);
				$article["sections"][$section] = $sectionItem;
			}
			
			$article["categories"][] = $item;
		}
	}	
	
	if (!empty($article["album_id"])) {
		$result = API_getDBItem(TABLE_GALLERY_ALBUM, " id = '".$article["album_id"]."'");
		if ($result["ok"]) {
			$album = $result["data"];
			$resultAlbum = API_getDBList(TABLE_GALLERY_PHOTOS, "album_id = ".$album["id"], "order_id asc", 100000);
			if ($resultAlbum["ok"]) {
				$album["photos"] = $resultAlbum["data"];
			}
			$article["album"] = $album;
		} 
	}
	
	if (!empty($article["categories"])) {
		$listItemsID = array();
		$sqlFilter = " (";
		foreach ($article["categories"] as $item) {
			$sqlFilter .= " `url` like '".$item["url"]."' or ";
		}
		$sqlFilter = substr($sqlFilter, 0, -3).")";
		
		$resultCategories = API_getDBList(TABLE_BLOG_ARTICLE_CATEGORIES, $sqlFilter);
		
		foreach ($resultCategories["data"] as $item) {
			// skip current article
			if ($item["article_id"] == $article["id"]) continue;
			if (!in_array($item["article_id"], $listItemsID)) {
				$listItemsID[] = $item["article_id"];
			}
		}
    	$sqlFilter = " `id` IN (".implode(",",$listItemsID).") ";
    	
    	$resultQuery = API_getDBListPaged(TABLE_BLOG_ARTICLES, $sqlFilter, "", $blog->relatedItemsCount);
	
		// get a list of albums from API result
		$listItems = $resultQuery["data"];

		// assign data to template
		MSV_assignData("blog_articles_related", $listItems);
	}

	
	// update views / +1
	API_updateDBItem(TABLE_BLOG_ARTICLES, "views", "views+1", " url = '".$articleUrl."'");
	
	// add item to page nativation line
	MSV_setNavigation($article["title"], $article["url"]);
	
	// assign data to template
	MSV_assignData("blog_article_details", $article);
}




function BlogInstall($module) {

	MSV_Structure_add("all", $module->baseUrl, "My Blog", "default", "main-blog.tpl", 1, "top", 10, "everyone");
	
}


function Blog_add($url, $post_date = "", $post_title = "", $post_description = "", $post_content = "", $pic = "", $pic_preview = "", $views = 0, $shares = 0, $lang = LANG) {
	if (empty($post_date)) {
		$post_date = "NOW()";
	}
	$picPath = "";
	if (!empty($pic)) {
		$picPath = MSV_storePic($pic, "jpg", "", TABLE_BLOG_ARTICLES, "pic");
	}
	$picPathPreview = "";
	if (!empty($pic)) {
		$picPathPreview = MSV_storePic($pic_preview, "jpg", "", TABLE_BLOG_ARTICLES, "pic_preview");
	}
	
	$item = array(
		"published" => 1,
		"url" => $url,
		"date" => $post_date,
		"title" => $post_title,
		"description" => $post_description,
		"text" => $post_content,
		"pic" => $picPath,
		"pic_preview" => $picPathPreview,
		"views" => $views,
		"shares" => $shares,
	);
	
	$result = API_itemAdd(TABLE_BLOG_ARTICLES, $item, $lang);
	
	if ($result["ok"]) {
		SEO_add($blog->baseUrl.$url."/", $post_title, $post_title, $post_title, 1, $lang);
	}
	
	return $result;
}
