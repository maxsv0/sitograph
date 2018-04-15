<?php
// *** include/class.msv.php
// *** DO NOT EDIT THIS FILE
// *** WILL BE OVERWRITTEN DURING UPDATE


class MSV_Website {
	public $debug 			= false;									// debug current page
	public $instaled 		= false;									// installation status
	public $protocol 		= "http://";							// default protocol
	public $host 			= "";									// current hostname
	public $port 			= 80;									// website port
	public $masterhost 		= "";									// hostname of default language website
	
	public $lang 			= "";									// current language
	public $langDefault 	= "";									// default language
	public $langUrl 		= "";									// url laguage prefix
	public $langSubdomain 	= false;								// alllow multi domain for languages, example: en.domain.com, ru.domain.com
	
	public $requestUrl		= "";						
	public $requestUrlRaw	= "";						
	public $requestUrlMatch = array();						
	public $languages 		= array();						
	public $modules 		= array();								// avaliable modules
	public $modulesActive 	= array();								// currenly enabled modules					
		
	public $config 			= array();								// website config
	public $structure 		= array();								// website structure
	public $menu 			= array();								// website menu
	public $navigation 		= array();								// website navigation line (breadcrumps)
	
	public $constants 		= array();								// website constants
	public $tables 			= array();								// 
	public $filters 		= array();								// 
	public $locales 		= array();								// 
	public $api		 		= array();								// API fucntion from modules
	public $messages 		= array();								// messages that will be ouptuted  on current page	
	public $page 			= array();								// current page row (from table structure)
	public $template 		= "default";							// 
	public $pageTemplate 	= "main.tpl";	
	public $pageTemplatePath= "";	
	public $document		= array();

	public $customPHP 		= array();								// list of php files that will be included
	
	public $htmlHead 		= "";									// include this into <head></head>
	public $htmlBodyBegin 	= "";									// include this after <body>
	public $htmlBodyEnd		= "";									// include this before </body>
	public $htmlFooter		= "";									// include this after </footer>
								//
	public $includeHead 	= array();								// include this lines beetween <head>
	public $includeCSS 		= array();								// insert this CSS files to head
	public $includeJS 		= array();								// insert this JS file to head
	public $includeJSCode 	= "";									// add this JS code in template
	public $includeHTMLCode = "";									// add this HTML code in template
	public $includeCSSCode 	= "";									// add this CSS code in template
	public $outputData		= "";									// app output

	public $log				= "";									// 
	public $logDebug		= "";									// 
	public $templateEngine			= "";                           //  Template Engine obj
	public $user			= array();								//  user info array
	
	
	function __construct() {
		$this->log("MSV: __construct");
		$tm = time() + (float)substr((string)microtime(), 1, 8);
		$this->config["timestampStart"] = $tm;
		
		$this->messages["error"] = array();
		$this->messages["success"] = array();
	}

	
	function __destruct() {
		$this->log("MSV: __destruct");

		// write to debug log
		if ($this->debug) {
			if (!file_exists(DEBUG_LOG)) {
				@touch(DEBUG_LOG);
			}
			if (defined("DEBUG_LOG") && is_writable(DEBUG_LOG)) {
				@file_put_contents(DEBUG_LOG, $this->logDebug, FILE_APPEND);
			}
		}
	}
	
	
	function start() {
	    $this->test_compatibility();

		// set languages
		if (defined("LANGUAGES")) {
			$this->languages = explode(",", LANGUAGES);
		} else {
			$this->outputError("Can't create website: Languages not set");
		}

		// set install flag depending to defined constant
		if (MSV_INSTALED) {
			$this->instaled = true;
		} else {
			$this->instaled = false;
			$this->log("MSV: setup required");
		}
		
		// if DB_REQUIRED, check for db config
		if (defined("DB_REQUIRED") && DB_REQUIRED) {
			if (!defined("DB_HOST")) {
				$this->outputError("DB_HOST not defined");
			}
			if (!defined("DB_LOGIN")) {
				$this->outputError("DB_LOGIN not defined");
			}
			if (!defined("DB_NAME")) {
				$this->outputError("DB_NAME not defined");
			}
		}
		
		// make db connection
		if (defined("DB_HOST") && defined("DB_LOGIN") && defined("DB_NAME")) {
			// set BD password
			$password = "";
			if (defined("DB_PASSWORD")) {
				$password = DB_PASSWORD;
			}

			// connect to database
			$conn = @mysqli_connect(DB_HOST, DB_LOGIN, $password, DB_NAME);
			$this->config["db"] = $conn;

			if (!$conn && DB_REQUIRED && $this->instaled) {
				$this->outputError("Can't connect to database. Please check if MySQL is running.");
			}
			
			if ($this->config["db"]) {
				// set encoding, if DATABASE_ENCODING
				if (defined("DATABASE_ENCODING") && DATABASE_ENCODING) {
					mysqli_query($this->config["db"], "set charset ".DATABASE_ENCODING);
					mysqli_query($this->config["db"], "set names ".DATABASE_ENCODING);
				}
			}
			
		} else {
			$this->config["db"] = false;
		}
		
		if (defined("SUBDOMAIN_LANGUAGES") && SUBDOMAIN_LANGUAGES) {
			$this->langSubdomain = true;
		} else {
			$this->langSubdomain = false;
		}

		// set host: current hostname of website
		// remove port from host
		if (strpos($_SERVER['HTTP_HOST'], ":") !== false) {
			list($this->host, $this->port) = explode(":", $_SERVER['HTTP_HOST']);
		} else {
			$this->host = $_SERVER['HTTP_HOST'];
		}

		// set lang: current language
		reset($this->languages);
		$this->lang = $this->langDefault = current($this->languages);

		if (!$this->langSubdomain) {
			// set masterhost
			$this->masterhost = $this->host;
		} else {
			// if $this->host start with en... ru .. 
			foreach ($this->languages as $k) {
				if (strpos($this->host, $k.".") === 0) {
					$this->lang = $k;
				}
			}
			
			// set masterhost
			if (strpos($this->host, $this->lang.".") === 0) {
				$this->masterhost = substr($this->host, strlen($this->lang)+1);
			} else {
				$this->masterhost = $this->host;
			}
		}

		if ($this->port !== 80) {
			$this->masterhost .= ":".$this->port;
		}

		// set lang  		
		if (!empty($_REQUEST["lang"])) {
			$lang = $_REQUEST["lang"];
	
			// ignore wrong $lang
			if (in_array($lang, $this->languages)) {
				$this->lang = $_REQUEST["lang"];
			}
		}
		
		// set langUrl
		if (!$this->langSubdomain && $this->lang !== $this->langDefault) {
			$this->langUrl = "/".$this->lang;
		} else {
			$this->langUrl = "";
		}
		
		// check MASTERHOST
		if (defined("MASTERHOST") && strlen(MASTERHOST) > 0) {
			if ($this->masterhost !== MASTERHOST) {
				$this->outputRedirect($this->protocol.MASTERHOST);
			}
		}
		
		// check DEBUG
		if (defined("DEBUG")) {
			$this->debug = DEBUG;
		} else {
			define("DEBUG", $this->debug);
		}
		
		// define constants
		
		define("HOST", $this->host);
		define("LANG", $this->lang); 
		define("LANG_URL", $this->langUrl);

		// set defaut protocol
		if (defined("PROTOCOL")) {
			$this->protocol = PROTOCOL;
		}
		
		// set homepage for each language
		foreach ($this->languages as $langID) {
			if ($langID !== $this->langDefault) {
				if ($this->langSubdomain) {
					$langHome = $this->protocol.$langID.".".$this->masterhost."/";
				} else {
					$langHome = $this->protocol.$this->masterhost."/?lang=".$langID;
				}
				
			} else {
				$langHome = $this->protocol.$this->masterhost."/";
			}			
			
			$this->config["home"][$langID] = $langHome;
		}
		$this->config["home_url"] = $this->config["home"][$this->lang];
		define("HOME_URL", $this->config["home_url"]);
		define("HOME_LINK", substr($this->config["home_url"], 0, -1));
		
		
		$this->config["languages"] = $this->languages;
		
		if (!empty($_SERVER["HTTP_REFERER"])) {
			$this->config["referer"] = $_SERVER["HTTP_REFERER"];
		}
		
		// link default mail function
		$this->config["mailer"] = "msv_email_default";
		
		$this->parseRequest();
		$this->activateCustom();
		$this->activateModules();
        $this->startTemplateEngine();

		// TODO: run all msv-* module?
		// run core, api, seo
		$this->runModule("msv-core");
		$this->runModule("msv-api");
		
		// is msv is already installed?
		if (!$this->instaled) {
			$this->runModule("install");
		}
		
		$this->runModule("msv-seo");
		
		$this->user = array(
			"access" => "anonymous",
			"pic" => CONTENT_URL."/images/icon-anonymous.png",
		);

		return true;
	}
	
	function load() {
		// redirect langDefault to main mirror
		if (strpos($this->host, $this->langDefault.".") === 0) {
			$urlGo = $this->protocol.$this->masterhost.$this->requestUrl;
			$this->outputRedirect($urlGo);
		}
		
		// run modules by level from 1 to 10
		for ($i = 1; $i <= 10; $i++) {
			$this->runLevel($i);
		}
		
		$this->loadPage($this->requestUrl);

		// apply filters
		$this->runFilters();
	}
	
	function loadPage($requestUrl) {
		$this->log("MSV: loadPage -> $requestUrl");
		if (empty($requestUrl)) return false;
		
		$page = array();
		foreach ($this->structure as $item) {
			if (strcmp($item["url"], $requestUrl) == 0) {
				$page = $item;
			}
		}
		$this->page = $page;

		if (empty($this->page)) {
			return false;
		}

		define("DEBUG_PAGE", $page["debug"]);

		$this->template = $page["template"];
		$this->pageTemplate = $page["page_template"];
		
		// check template file
		$templatePath = ABS_TEMPLATE."/".$this->template."/".$this->pageTemplate;
		if (!file_exists($templatePath) || 
			!is_readable($templatePath) || 
			!is_file($templatePath)) {
			
			// if template not found in dir, fall back to 'default' theme
			$this->template = 'default';
			$templatePath = ABS_TEMPLATE."/".$this->template."/".$this->pageTemplate;
		}
		$this->pageTemplatePath = $templatePath;
		
		return true;
	}
	
	function runFilters() {
		$this->log("MSV: runFilters");
		
		if (empty($this->filters)) return false;
		if (!is_array($this->filters)) return false;
		
		// run filter by module activation level
		for ($i = 1; $i <= 10; $i++) {
			
			$this->runFiltersLevel($i);
		}
		
		return true;
	}
	function runFiltersLevel($index) {
		// TODO: check $index
		foreach ($this->filters as $filter) {
			$obj = $this->{$filter["module"]};

			if ($obj->activationLevel == $index) {

				$r = $obj->runFilter($filter);
				if ($r) {
					$this->log("MSV: runFilter -> ".$filter["action"]." successfull (level $index)");
				} else {
					//$this->log("MSV: skip runFilter -> ".$filter["action"]." (level $index)");
				}
			}
		}
	}
	function runLevel($index) {
		// TODO: check $index
		
		foreach ($this->modules as $v) {
			if (in_array($v, $this->modulesActive)) continue;
			$obj = $this->{$v};
			if ($obj->activationLevel == $index) {
				
				$r = $this->runModule($v);
			}
		}
	}
	function activateModule($module) {
		$obj = new MSV_Module($module);
		if ($obj) {
        	// attach module object LINK to website 
        	// TODO: dont overwrite existing objects
        	$this->{$module} = &$obj;
        	$obj->website = &$this;
        }
		
	}
	function runModule($module) {
		// TODO: check $module
		// if in $this->modules[]
		// if in $this->modulesActive[]
		
		// TODO: check dep for $module
		$obj = $this->{$module};
        if ($obj) {
        	if (!empty($obj->config)) {
        		$this->config[$module] = $obj->config;
        	}
        	if (!empty($obj->constants) && is_array($obj->constants)) {
        		$this->constants = array_merge($this->constants, $obj->constants);
        	}
        	if (!empty($obj->tables) && is_array($obj->tables)) {
        		$this->tables = array_merge($this->tables, $obj->tables);
        	}
        	if (!empty($obj->filters) && is_array($obj->filters)) {
        		$this->filters = array_merge($this->filters, $obj->filters);
        	}
        	if (!empty($obj->locales) && is_array($obj->locales)) {
        		$this->locales = array_merge($this->locales, $obj->locales);
        	}
        	if (!empty($obj->api) && is_array($obj->api)) {
        		$this->api = array_merge($this->api, $obj->api);
        	}
        	
        	if (!$this->instaled) {
				//during installation run all php, dont check url
	        	$result = $obj->runUrl("*");
        	} else {
        		// include module php file
	        	$result = $obj->runUrl($this->requestUrl);
        	}
        	
        	if ($result) {
        		$this->modulesActive[] = $module;
        		$this->log("MSV -> $module active");
        	}
        } else {
        	$this->outputError("Can't run module '$module'. Not activated");
		}	
	}
	function activateModules() {
		if ($handle = opendir(ABS_MODULE)) {
		    while (false !== ($entry = readdir($handle))) {
		    	if (strpos($entry, ".") === 0) {
		    		continue;
		    	}
		    	$modulePath = ABS_MODULE."/".$entry;
		    	if (!is_dir($modulePath)) {
		    		continue;
		    	}
		    	if (strpos($entry, "-") === 0) {
		    		$entry = substr($entry, 1);
		    		// TODO: check why cant accept moduel with -
		    		continue;
		    	}
		        // add module to list of avaliable modules
		        $this->modules[] = $entry;
		    }
			closedir($handle);
		}
		$this->log("MSV: activateModules -> ".implode(",",$this->modules));
		
		foreach ($this->modules as $v) {
			$this->activateModule($v);
		}
	}
	function activateCustom() {
		// TODO: check input data
		if (!defined("ABS_CUSTOM")) return false;
		if (!file_exists(ABS_CUSTOM)) return false;
		if (!is_dir(ABS_CUSTOM)) return false;
		
		if ($handle = opendir(ABS_CUSTOM)) {
		    while (false !== ($entry = readdir($handle))) {
		    	if (strpos($entry, ".") === 0) {
		    		continue;
		    	}
		    	$filePath = ABS_CUSTOM."/".$entry;
		    	if (is_dir($filePath)) {
		    		continue;
		    	}
		        $this->customPHP[] = $entry;
		    }
			closedir($handle);
		}
		$this->log("MSV: activateCustom -> ".implode(",",$this->customPHP));
		foreach ($this->customPHP as $v) {
			require_once(ABS_CUSTOM."/".$v);
		}
	}
	
	function setRequestUrl($url) {
		// TODO: check $url
		
		$this->requestUrl = $url;
	}

	function parseRequest() {
        // normally we read REQUEST_URI
        // if `server_redirect` was passed in REQUEST then REDIRECT_URL will be used
        $requestUrl = $_SERVER["REQUEST_URI"];
        if (isset($_REQUEST["server_redirect"])) {
            $requestUrl = $_SERVER["REDIRECT_URL"];
        }

        // if langSubdomain then lang ID is passed in URL
        // otherwise, lang is a subdomain
        if (!$this->langSubdomain) {
            // concat request URL to remove lang ID
            foreach ($this->languages as $langName) {
                if (substr($requestUrl, 0, 4) === "/" . $langName . "/") {
                    $requestUrl = substr($requestUrl, 3);

                    // if default language is used in URL -> redirect
                    if ($langName === $this->langDefault) {
                        $this->outputRedirect($requestUrl);
                    }
                }
            }
        }
		
		$ar = explode("?", $requestUrl, 2);
		$requestUrl = $ar[0];
		if (!empty($ar[1])) {
			$params = $ar[1];
		}
		$this->requestUrl = $requestUrl;
		$this->requestUrlRaw = $requestUrl;
		
		$lastChar = substr($requestUrl, -1, 1);
		if ($lastChar === "/") {
			$this->config["hasTrailingSlash"] = true;
		} else {
			$this->config["hasTrailingSlash"] = false;
		}
	}

    function startTemplateEngine() {
        if (!empty($this->templateEngine)) {
            return false;
        }

        $Smarty = new Smarty;
        $Smarty->debugging = false;

        $Smarty->caching = false;
        $Smarty->cache_lifetime = 120;

        $Smarty->template_dir = ABS_TEMPLATE;

        $Smarty->debug_tpl = SMARTY_DIR."debug.tpl";

        $compile_dir = SMARTY_DIR."cache";
        if (!is_writeable($compile_dir)) {
            $this->outputError("Cant write to $compile_dir");
        }
        $Smarty->compile_dir = $compile_dir;
        $Smarty->compile_check = true;

        $Smarty->assign("themeDefaultPath", ABS_TEMPLATE."/default");
        $Smarty->assign("content_url", CONTENT_URL);

        $this->templateEngine =& $Smarty;
    }

    function initTemplateEngine() {
        if (empty($this->templateEngine)) {
            $this->outputError("Template Engine not found");
        }

        // enable debug if DEBUG_PAGE is true
        if (defined("DEBUG_PAGE") && DEBUG_PAGE) {
            $this->templateEngine->debugging = true;
        }

        $this->includeCSS = array_reverse($this->includeCSS);
        foreach ($this->includeCSS as $filePath) {
            $this->includeHead[] = "<link href=\"$filePath\" rel=\"stylesheet\">";
        }

        $this->includeHead = array_reverse($this->includeHead);
        foreach ($this->includeHead as $line) {
            $this->htmlHead .= $line."\n";
        }

        $includeHTML = "";
        foreach ($this->includeJS as $filePath) {
            $includeHTML = $includeHTML."<script src=\"$filePath\"></script>\n";
        }
        if ($this->includeCSSCode) {
            $includeHTML = "<style>\n".$this->includeCSSCode."</style>\n.$includeHTML";
        }

        if ($this->includeJSCode) {
            $includeHTML = $includeHTML."<script>\n".$this->includeJSCode."</script>\n";
        }
        if ($this->includeHTMLCode) {
            $includeHTML = "\n".$this->includeHTMLCode.$includeHTML;
        }

        if (defined("JS_BEFORE_BODY") && JS_BEFORE_BODY) {
            // include HTML to head
            $this->htmlHead = $this->htmlHead.$includeHTML;
        } else {
            // include HTML to footer
            $this->htmlFooter = $includeHTML.$this->htmlFooter;
        }

        $this->templateEngine->assign("htmlHead", $this->htmlHead);
        $this->templateEngine->assign("htmlFooter", $this->htmlFooter);

        $this->templateEngine->assign("host", $this->host);
        $this->templateEngine->assign("masterhost", $this->masterhost);
        $this->templateEngine->assign("lang", $this->lang);
        $this->templateEngine->assign("navigation", $this->navigation);
        $this->templateEngine->assign("menu", $this->menu);
        $this->templateEngine->assign("structure", $this->structure);
        $this->templateEngine->assign("page", $this->page);
        $this->templateEngine->assign("page_template", $this->page["page_template"]);
        $this->templateEngine->assign("themePath", ABS_TEMPLATE."/".$this->template);

        // assign config values directly to template
        foreach ($this->config as $param => $value) {
            $param = str_replace("-", "_", $param);
            $this->templateEngine->assign($param, $value);
        }

        // also assign config as array
        $this->templateEngine->assign("config", $this->config);

        // assign page messages
        $messageError = implode("<br>\n", $this->messages["error"]);
        $this->templateEngine->assign("message_error", $messageError);

        $messageSuccess = implode("<br>\n", $this->messages["success"]);
        $this->templateEngine->assign("message_success", $messageSuccess);

        $this->templateEngine->assign("document", $this->document);
        if (!empty($this->document_blocks)) {
            $this->templateEngine->assign("document_blocks", $this->document_blocks);
        }
        $this->templateEngine->assign("tables", $this->tables);
        $this->templateEngine->assign("user", $this->user);

        $this->templateEngine->assign("t", $this->locales);
        $this->templateEngine->assign("rand", rand());

        $this->templateEngine->assign("request_url", $this->requestUrl);
        $this->templateEngine->assign("lang_url", $this->langUrl);

        return true;
    }

	function output($output, $code = 200) {
		if ($code === 200) {
			echo $output;
		} elseif ($code === 500) {
            header("HTTP/1.0 500 Internal Server Error");
			echo $output;
		} elseif ($code === 404) {
			header("HTTP/1.0 404 Not Found");
			echo $output;
		} elseif ($code === 403) {
			header('HTTP/1.0 403 Forbidden');
		} elseif ($code === 301) {
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: $output");
			echo "Redirection to <a href=='$output'>$output</a> .. ";
		}
	}
	function outputError($errorText = "") {
		$str = "<body style='background:#eee;height:100%;margin:0;'>";
		$str .= "<div style='position: absolute; bottom: 50%; left:47%;'>";
		$str .= "<span style='color:red;'>WEBSITE ERROR.</span>";
		$str .= "</div>";
		$str .= "<div style='position: absolute; bottom: 0; padding:5px 20px; background:#00f;'>";
		$str .= "<span style='color:red;'>ERROR: ".nl2br($errorText)."</span>";
		$str .= "</div>";

        // Error page -> auto reload
        // https://github.com/maxsv0/sitograph/issues/113
		$str .= "<script>";
		$str .= "setTimeout(function(){window.history.back();}, 5000);";
		$str .= "</script>";
		$this->output($str, 500);
	}
	function outputNotFound($output = "") {
		if (empty($output)) {
			$output = "Page not found.";
		}
		$this->output($output, 404);
	}
	
	function outputForbidden() {
		$this->output("", 403);
	}
	
	function outputRedirect($url) {
		// TODO +++: emulate request on redirect (_POST, GET, _FILES..)
		$this->output($url, 301);
	}
	function checkAccess($pageAccess, $userAccess = '') {
		if (!$this->instaled) {
			return true;
		}
		
		if ($pageAccess === "everyone") {
			return true;
		}
		if ($userAccess === "dev") {
			return true;
		}
		if ($pageAccess === "admin" && ($userAccess === "admin" || $userAccess === "dev")) {
			return true;
		}
		if ($pageAccess === "user" && ($userAccess === "user" || $userAccess === "admin" || $userAccess === "dev")) {
			return true;
		}
		return false;
	}
	function outputPage() {
		$this->log("MSV: outputPage");

		if ($this->instaled && (empty($this->page) || empty($this->page["published"]))) {
			// set 404 template

			$this->log("Page not found, loading 404 template");
			$this->loadPage("/404/");

			// reload page document
            msv_load_pagedocument();

			header("HTTP/1.0 404 Not Found");

			// TODO: output this if 404 template not found
			//$this->outputNotFound("Page not found", 404);
		}

		$userAccess = $this->user["access"];
		$pageAccess = $this->page["access"];
		if (!$this->checkAccess($pageAccess, $userAccess)) {
			// set redirect url to return after login
			$_SESSION["redirect_url"] = $this->requestUrlRaw;
			
			if ($this->page["url"] === "/admin/") {
				// redirect to login page
				$this->outputRedirect("/admin/login/");
			} else {
				// redirect to login page
				$this->outputRedirect("/login/");
			}
		}

		// check template file
		if (!file_exists($this->pageTemplatePath) || 
			!is_readable($this->pageTemplatePath) || 
			!is_file($this->pageTemplatePath)) {
			$this->outputError("Page template not found: ".$this->pageTemplatePath);
		}

        if (!empty($_REQUEST["ajaxcall"])) {
            if (!empty($this->messages["error"])) {
                $result = array(
                    "ok" => false,
                    "msg" => implode("\n", $this->messages["error"]),
                );
            } else {
                $result = array(
                    "ok" => true,
                    "msg" => implode("\n", $this->messages["success"]),
                );
            }

            echo json_encode($result);
            die;
        }

		// output debug console, if needed
		if (defined("DEBUG_PAGE") && DEBUG_PAGE) {
			$this->outputDebug();
		}
		
		// init Template Engine
		$this->initTemplateEngine();

		// Disable ERR_BLOCKED_BY_XSS_AUDITOR
		// https://github.com/maxsv0/sitograph/issues/134
        if ($this->page["url"] === "/admin/") {
            header('X-XSS-Protection:0');
        }

		// calculate script running time and log
		$tm = time() + (float)substr((string)microtime(), 1, 8);
		$this->config["timestampEnd"] = $tm;
		$scriptTime = $this->config["timestampEnd"] - $this->config["timestampStart"];
		$scriptTime = round($scriptTime, 6);
		$this->log("Run time: $scriptTime sec");

        // output current page, use Template Engine object
        return $this->templateEngine->fetch($this->pageTemplatePath);
	}
	
	function outputDebug() {
		$debugHTML = "";
		$debugHTML .= "<div class='debug_log'>";
		$debugHTML .= "<pre class='pre-scrollable'>";
		$debugHTML .= $this->logDebug;
		$debugHTML .= "</pre>";
		$debugHTML .= '</div>';
		
		$this->config["debug_code"] = $debugHTML;
		return true;
	}

	function log($logText = "", $type = "warning") {
		$date = date("Y-m-d H:i:s").substr((string)microtime(), 1, 8);
		$logLine = $date." ".$logText."\n";
		
		if ($type === "debug") {
			$this->logDebug .= $logLine;
		} else {
			$this->log .= $logLine;
			$this->logDebug .= $logLine;
		}
	}

    function test_compatibility() {
        if (!extension_loaded("simplexml")) {
            $this->outputError("Required extension not found: <b>simplexml</b>");
        }
        if (DB_REQUIRED && !extension_loaded("mysqli")) {
            $this->outputError("Required extension not found: <b>mysqli</b>");
        }
        if (USER_HASH_PASSWORD && !function_exists("password_hash")) {
            $this->outputError("Required function not found: <b>password_hash</b>");
        }

        if(function_exists("apache_get_modules")) {
            if (!in_array('mod_rewrite', apache_get_modules())) {
                $this->outputError("Required module not found: <b>mod_rewrite</b>");
            }
        }
    }
}
