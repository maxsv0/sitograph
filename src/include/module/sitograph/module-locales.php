<?php

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
    if (!empty($_REQUEST["module"]) || !empty($_REQUEST["form_module"])) {
     !empty($_REQUEST["form_module"]) ? $_REQUEST["module"] = $_REQUEST["form_module"]:'';
     !empty($_REQUEST["form_name"]) && !empty($_REQUEST["form_module"]) ? $_POST["itemID"] = $_REQUEST["form_name"]:'';
     
     $moduleObj = msv_get("website.".$_REQUEST["module"]);
     $config_path = $moduleObj->pathConfig;
     
     $_SESSION['location_active'] = $_REQUEST["module"];
     
     $configXML = simplexml_load_file($config_path); 
     
     if (!is_writable($config_path)) {
         msv_message_error("Can't write to file '$config_path'");
		unset($_POST["save"]);
		return;
     }
     
     
     foreach ($configXML->locales->locale as $loc) {
        $attributes = $loc->attributes();
        if ((string)$attributes["name"] == LANG) {
           if (!empty($_REQUEST["form_module"])) { 
            $new_rec = $loc->addChild('field');
            $new_rec->addAttribute('name', $_REQUEST["form_name"]);
            $new_rec->addAttribute('value', $_REQUEST["form_value"]);
           } else { 
            foreach ($loc as $fields) {
                $attributes = $fields->attributes();
                if ((string)$attributes["name"] == $_REQUEST['itemID']) {
                    $attributes["value"] = $_REQUEST['form_value'];
                }
            }
           } 
        }
        
     } 
    // echo("<pre>".htmlspecialchars($configXML->asXML())."</pre>");
     $configXML->asXml($config_path);
   }  
   
   if (!empty($_POST["save_exit"])) {
//	MSV_redirect($this->website->langUrl."/admin/?section=$section");
   } 
}

if (!empty($_POST["save"])) {
	$_REQUEST["edit"] = $_POST["itemID"];
}

if (!empty($_REQUEST["delete"])) {
    if (!empty($_REQUEST["module"])) {
        $_SESSION['location_active'] = $_REQUEST["module"];
        $moduleObj = msv_get("website.".$_REQUEST["module"]);
        $config_path = $moduleObj->pathConfig;
        $configXML = simplexml_load_file($config_path); 
        foreach ($configXML->locales->locale as $loc) {
        $attributes = $loc->attributes();
        if ((string)$attributes["name"] == LANG) {
            $res = $loc->xpath('field[@name="'.$_REQUEST["delete"].'"]');
            $parent = $res[0];
            unset($parent[0]);
        }
       } 
     //  echo("<pre>".htmlspecialchars($configXML->asXML())."</pre>");
       $configXML->asXml($config_path);       
    }
    msv_redirect($this->website->langUrl."/admin/?section=$section");
}



if (isset($_REQUEST["add_new"])) {
   $modules = array();
    foreach ($this->website->modules as $module) {
    	$modules[$module] = $module;
    }
 
    $admin_edit = array();
    
    $admin_edit[] = array(
    'name' =>'Модуль',
    'field_name' =>'module',
    'type' =>'select',
    'value' =>'',
    'data' =>$modules,
    );
    
    $admin_edit[] = array(
    'name' =>'Переменная',
    'field_name' =>'name',
    'type' =>'str',
    'value' =>'',
    );
    
    $admin_edit[] = array(
    'name' =>'Значение',
    'field_name' =>'value',
    'type' =>'str',
    'value' =>'',
    );

    msv_assign_data("admin_edit", $admin_edit);
    msv_assign_data("add", 1);
    
} elseif (isset($_REQUEST["edit"])) {
   
    $moduleObj = msv_get("website.".$_REQUEST["module"]);
    $itemField = array(
    'name' =>'',
    'field_name' =>'value',
    'type' =>'str',
    'item_edit' =>$_REQUEST["edit"],
    'value' =>!empty($_REQUEST["form_value"])? $_REQUEST["form_value"]:$moduleObj->locales[$_REQUEST["edit"]],
    'module' =>$_REQUEST["module"]
    );
    
  //   var_dump($moduleObj->locales[$_REQUEST["edit"]]);
    msv_assign_data("itemField", $itemField);
    msv_assign_data("edit", 1);
} else {
    $module_locales = array();
    foreach ($this->website->modules as $module) {
    	$moduleObj = msv_get("website.".$module);
    	$module_locales[$module] = $moduleObj->locales;
    }

    msv_assign_data("admin_module_locales", $module_locales);
    msv_assign_data("admin_locales", $this->website->locales);
    msv_assign_data("locales_active", $_SESSION['location_active']);
}