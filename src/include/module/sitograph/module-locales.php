<?php
if (!empty($_POST["save_exit"]) || !empty($_POST["save"]) || !empty($_REQUEST["delete"])) {
    $moduleName = $_REQUEST["form_module"];
    if (empty($moduleName)) {
        msv_message_error("Empty field: module");
        return;
    }
    $moduleObj = msv_get("website.".$moduleName);
    if (empty($moduleObj)) {
        msv_message_error("Can't find module ".$moduleName);
        return;
    }

    $moduleConfig = $moduleObj->pathModuleConfig;

    $configLocales = "";
    foreach ($moduleConfig as $path) {
        if (substr($path, -12) === ".locales.xml") {
            $configLocales = $path;
        }
    }

    $textID = $_REQUEST["form_name"];
    $textValue = $_REQUEST["form_value"];

    if (empty($configLocales)) {
        msv_message_error("Locales file (config.locales.xml) was not found. <br>Current config:<br>".implode("<br>", $moduleConfig));
    } elseif (!is_writable($configLocales)) {
        msv_message_error("Can't write to file '$configLocales'");
    } elseif (empty($_REQUEST["delete"]) && empty($textID)) {
        msv_message_error("TextID can't be empty");
    }

    if (!msv_has_messages()) {
        $configXML = simplexml_load_file($configLocales);

        foreach ($configXML->locales->locale as $loc) {
            $attributes = $loc->attributes();
            if ((string)$attributes["name"] == LANG) {

                if (!empty($_REQUEST["delete"])) {
                    $res = $loc->xpath('field[@name="'.$_REQUEST["delete"].'"]');
                    $parent = $res[0];
                    unset($parent[0]);
                } else {
                    $replaced = false;
                    foreach ($loc as $fields) {
                        $attributes = $fields->attributes();
                        if ((string)$attributes["name"] == $textID) {
                            $attributes["value"] = $textValue;
                            $replaced = true;
                        }
                    }

                    // add new if not found
                    if (!$replaced) {
                        $new_rec = $loc->addChild('field');
                        $new_rec->addAttribute('name', $textID);
                        $new_rec->addAttribute('value', $textValue);
                    }
                }
            }
        }

        $configXML->asXml($configLocales);

        if (!empty($_POST["save"])) {
            msv_redirect(ADMIN_URL."?section=locales&edit=$textID&module=$moduleName&msg="._t("msg.saved_ok"));
        } else {
            msv_redirect(ADMIN_URL."?section=locales&msg="._t("msg.saved_ok")."#module-".$moduleName);
        }
    }
}

if (isset($_REQUEST["export_po"])) {
    header('Content-Encoding: UTF-8');
    header('Content-type: plain/text; charset=UTF-8');
    header('Content-Disposition: attachment; filename=sitograph_'.LANG.'.po');

    $export_locales = 'msgid ""
msgstr ""
"Project-Id-Version: \n"
"POT-Creation-Date: \n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"Language: '.LANG.'\n"

    ';

    $module_locales = array();
    foreach ($this->website->modules as $module) {
        $moduleObj = msv_get("website.".$module);
        foreach ($moduleObj->locales as $textID => $textString) {

            $export_locales .= 'msgid "'.$module.'.'.$textID.'"
msgstr "'.$textString.'"

';
        }
    }




    msv_output($export_locales);
    die;
}


if (isset($_REQUEST["add_new"])) {
    $admin_edit = array(
        'lang' => LANG,
        'module' => "",
        'name' => "",
        'value' => "",
    );

    msv_assign_data("admin_edit", $admin_edit);
    msv_assign_data("add", 1);
} elseif (isset($_REQUEST["edit"])) {
    $locales = msv_get("website.".$_REQUEST["module"].".locales");

    $admin_edit = array(
        'lang' => LANG,
        'module' => $_REQUEST["module"],
        'name' => $_REQUEST["edit"],
        'value' => $locales[$_REQUEST["edit"]],
    );

    msv_assign_data("admin_edit", $admin_edit);
    msv_assign_data("edit", 1);
} else {
    $module_locales = array();
    foreach ($this->website->modules as $module) {
    	$moduleObj = msv_get("website.".$module);
    	$module_locales[$module] = $moduleObj->locales;
    }

    msv_assign_data("admin_module_locales", $module_locales);
}

// prepare form
$modulesList = msv_get("website.modules");
foreach ($modulesList as $module) {
    $name = msv_get("website.$module.title");
    $modules[$module] = $name;
}

$admin_tabs = array();
$admin_tabs["home"] = array(
    "title" => "General",
    "fields" => array(
        array(
            "name" => "lang",
            "type" => "str",
            "title" => _t("table.settings.lang"),
            "readonly" => 1,
        ),
        array(
            "name" => "module",
            "type" => "select",
            "title" => 'Module',
            'data' => $modules
        ),
        array(
            "name" => "name",
            "type" => "str",
            "title" => _t("admin.locale_param")
        ),
        array(
            "name" => "value",
            "type" => "str",
            "title" =>  _t("admin.locale_value")
        ),
    ),
);

msv_assign_data("admin_edit_tabs", $admin_tabs);