<?php


 
function ajax_More_Search($module)
{
    $items_per_page = 10;
    $res = array();
    $_REQUEST['keyword'] = trim($_REQUEST['keyword']);
    
        $module_search = array();
        
        if (!empty($_REQUEST['keyword']))
        {
            $_REQUEST['keyword'] = trim($_REQUEST['keyword']);
            $search = array(
                "'<script[^>]*?>.*?</script>'si", // Вырезает javaScript
                "'<[\/\!]*?[^<>]*?>'si", // Вырезает HTML-теги
                "'([\r\n])[\s]+'", // Вырезает пробельные символы
                "'&(quot|#34);'i", // Заменяет HTML-сущности
                "'&(amp|#38);'i",
                "'&(lt|#60);'i",
                "'&(gt|#62);'i",
                "'&(nbsp|#160);'i",
                "'&(iexcl|#161);'i",
                "'&(cent|#162);'i",
                "'&(pound|#163);'i",
                "'&(copy|#169);'i",
                "'&#(\d+);'i");
            $_REQUEST['keyword'] = strip_tags(preg_replace($search, "", $_REQUEST['keyword']));
            $tables_info = msv_get("website.tables");
            $website = msv_get("website");
            
            $ignore_tables = array(
                'settings',
                'mail_templates',
                'menu',
                'search',
                'seo',
                'users');
            $modules_base_url = array();
            foreach ($website->modules as $v => $k)
            {
                $attr = $website->config[$k]->attributes();
                $url = (string )$attr['baseUrl'];
                if (!empty($url))
                {
                    foreach ($website->config[$k]->table as $m => $n)
                    {
                        $attr = $n->attributes();
                        $modules_base_url[(string )$attr['name']]['url'] = $url;
                        $modules_base_url[(string )$attr['name']]['title'] = (string )$attr['title'];
                    }
                }
            }
            foreach ($tables_info as $v => $db_tables_info)
            {
                
                if (in_array($v, $ignore_tables))
                    continue;
                $filter = '';
                $field_list = array();
                foreach ($db_tables_info['fields'] as $field => $attr)
                {
                    switch ($attr['type'])
                    {
                        case 'str':
                            $filter .= " `" . $field . "` like '%" . $_REQUEST['keyword'] . "%' or";
                            $field_list[] = $field;
                            break;
                        case 'text':
                            $filter .= " `" . $field . "` like '%" . $_REQUEST['keyword'] . "%' or";
                            $field_list[] = $field;
                            break;
                        case 'doc':
                            $filter .= " `" . $field . "` like '%" . $_REQUEST['keyword'] . "%' or";
                            $field_list[] = $field;
                            break;
                    }
                }
                if (!empty($field_list))
                {
                    $title = '';
                    $filter = substr($filter, 0, -2);
                    $field_str = implode(',', $field_list);
                    $sqlCode = "select * from " . $v . " where (" . $filter . ") and `lang`='" .
                        LANG . "'";
                    $result = db_sql($sqlCode);
                    if (!$result["ok"])
                    {
                        msv_message_error($result["msg"]);
                    }
                    $i = 0;
                    while ($row = db_fetch_row($result["data"]))
                    {
                        
                        $url = '';
                        if ($v == 'documents')
                        {
                            $structure_row = db_get('structure', " `page_document_id` = '" . $row['id'] .
                                "' and `lang`='" . LANG . "'");
                            if (!empty($structure_row['data']))
                            {
                                $url = $structure_row['data']['url'];
                                $title = $structure_row['data']['name'];
                            }
                        } elseif ($v == 'structure')
                        {
                            $url = $row['url'];
                            $title = $row['name'];
                        } else
                        {
                            $title = msv_highlight_text($_REQUEST['keyword'], $row[$modules_base_url[$v]['title']], 10);
                            $url = $modules_base_url[$v]['url'] . (!empty($row['url']) ? $row['url'] . '/' :
                                '');
                        }
                        if (!empty($url))
                        {
                            $ar2 = array();
                            $ar2["title"] = $title;
                            $text = "";
                            foreach ($field_list as $field)
                            {
                                //   $text .="Поле:".$field." ".$row[$field];
                                if (strpos(strtoupper($row[$field]), strtoupper($_REQUEST['keyword'])) === false)
                                {
                                    continue;
                                } else
                                {
                                    $text .= $row[$field] . " ";
                                }
                            }
                            $a = strpos($text, $_REQUEST['keyword']);
                            if ($a < 300)
                            {
                                $a = 300;
                            }
                            if ($v == 'structure')
                            {
                                $text = $title;
                            }
                            $text = strip_tags(preg_replace($search, "", $text));
                            $text = mb_substr($text, $a - 300, 300);
                            $ar2["text"] = msv_highlight_text($_REQUEST['keyword'], $text, 50);
                            $ar2["url"] = $url;
                            $module_search[] = $ar2;
                            $i++;
                        }
                    }
                } // !empty($field_list)
            } // foreach $tables_info
        } // !empty($_REQUEST['keyword'])
        

    $num_rows = count($module_search);
    
    $out_ar = array_slice($module_search,((int)$_GET['nextpage']*$items_per_page),$items_per_page);
    
    $html ='';
    foreach ($out_ar as $v=>$k) {
            $html .='<div class="search-result">';
            $html .='<a class="bg_red" href="'.$k['url'].'"><b>'.$k['title'].'</b></a>';
            $html .='<p>'.$k['text'].'</p>';
            $html .='</div>';
    }
    
   // var_dump($html);
    if ($num_rows > ((int)$_GET['nextpage']+1)*$items_per_page) {
        $html .='<div class="btn_more" data-nextpage="'.((int)$_REQUEST['nextpage']+1).'" data-search="'.$_REQUEST['keyword'].'"  onclick="Get_More_Search(this)">'._t("search.more_search").'</div>';
    }
    
   //	unset($resultQuery['data']);
    $res['ok'] = 1;
    $res['data'] = $html;

    return json_encode($res);
}


function Get_Search_List($module)
{
    $items_per_page = 10;
    if (isset($_GET['search']))
    {
        $module_search = array();
        if (!empty($_GET['search']) && empty($_POST['keyword']))
        {
            $_POST['keyword'] = trim($_GET['search']);
        }
        if (!empty($_POST['keyword']))
        {
            $_POST['keyword'] = trim($_POST['keyword']);
            $search = array(
                "'<script[^>]*?>.*?</script>'si", // Вырезает javaScript
                "'<[\/\!]*?[^<>]*?>'si", // Вырезает HTML-теги
                "'([\r\n])[\s]+'", // Вырезает пробельные символы
                "'&(quot|#34);'i", // Заменяет HTML-сущности
                "'&(amp|#38);'i",
                "'&(lt|#60);'i",
                "'&(gt|#62);'i",
                "'&(nbsp|#160);'i",
                "'&(iexcl|#161);'i",
                "'&(cent|#162);'i",
                "'&(pound|#163);'i",
                "'&(copy|#169);'i",
                "'&#(\d+);'i");
            $_POST['keyword'] = strip_tags(preg_replace($search, "", $_POST['keyword']));
            $tables_info = msv_get("website.tables");
            $ignore_tables = array(
                'settings',
                'mail_templates',
                'menu',
                'search',
                'seo',
                'users');
            $modules_base_url = array();
            foreach ($module->website->modules as $v => $k)
            {
                $config = msv_get_config($k);
                $url = $config["baseUrl"];
                if (!empty($config["baseUrl"]))
                {
                    $tables = msv_get("website.".$k.".tables");
                    foreach ($tables as $m => $attr)
                    {
                        $modules_base_url[(string )$attr['name']]['url'] = $url;
                        $modules_base_url[(string )$attr['name']]['title'] = (string )$attr['title'];
                    }
                }
            }
            foreach ($tables_info as $v => $db_tables_info)
            {
                if (in_array($v, $ignore_tables))
                    continue;
                $filter = '';
                $field_list = array();
                foreach ($db_tables_info['fields'] as $field => $attr)
                {
                    switch ($attr['type'])
                    {
                        case 'str':
                            $filter .= " `" . $field . "` like '%" . $_POST['keyword'] . "%' or";
                            $field_list[] = $field;
                            break;
                        case 'text':
                            $filter .= " `" . $field . "` like '%" . $_POST['keyword'] . "%' or";
                            $field_list[] = $field;
                            break;
                        case 'doc':
                            $filter .= " `" . $field . "` like '%" . $_POST['keyword'] . "%' or";
                            $field_list[] = $field;
                            break;
                    }
                }
                if (!empty($field_list))
                {
                    $title = '';
                    $filter = substr($filter, 0, -2);
                    $field_str = implode(',', $field_list);
                    $sqlCode = "select * from " . $v . " where (" . $filter . ") and `lang`='" .
                        LANG . "'";
                    $result = db_sql($sqlCode);
                    if (!$result["ok"])
                    {
                        msv_message_error($result["msg"]);
                    }
                    $i = 0;
                    while ($row = db_fetch_row($result["data"]))
                    {
                        $url = '';
                        if ($v == 'documents')
                        {
                            $structure_row = db_get('structure', " `page_document_id` = '" . $row['id'] .
                                "' and `lang`='" . LANG . "'");
                            if (!empty($structure_row['data']))
                            {
                                $url = $structure_row['data']['url'];
                                $title = $structure_row['data']['name'];
                            }
                        } elseif ($v == 'structure')
                        {
                            $url = $row['url'];
                            $title = $row['name'];
                        } else
                        {
                            $title = msv_highlight_text($_POST['keyword'], $row[$modules_base_url[$v]['title']], 10);
                            $url = $modules_base_url[$v]['url'] . (!empty($row['url']) ? $row['url'] . '/' :
                                '');
                        }
                        if (!empty($url))
                        {
                            $ar2 = array();
                            $ar2["title"] = $title;
                            $text = "";
                            foreach ($field_list as $field)
                            {
                                //   $text .="Поле:".$field." ".$row[$field];
                                if (strpos(strtoupper($row[$field]), strtoupper($_POST['keyword'])) === false)
                                {
                                    continue;
                                } else
                                {
                                    $text .= $row[$field] . " ";
                                }
                            }
                            $a = strpos($text, $_POST['keyword']);
                            if ($a < 300)
                            {
                                $a = 300;
                            }
                            if ($v == 'structure')
                            {
                                $text = $title;
                            }
                            $text = strip_tags($text);
                            $text = mb_substr($text, $a - 300, 300);
                            $ar2["text"] = msv_highlight_text($_POST['keyword'], $text, 50);
                            $ar2["url"] = $url;
                            $module_search[] = $ar2;
                            $i++;
                        }
                    }
                } // !empty($field_list)
            } // foreach $tables_info
        } // !empty($_POST['keyword'])
        
        if (!empty($module_search))
        {
            if (count($module_search) > $items_per_page)
            {
                msv_assign_data("set_more", 1);
            }
            msv_assign_data("search_result", array_slice($module_search, 0, $items_per_page));
            msv_assign_data("search_count", count($module_search));
        } else
        {
            msv_assign_data("search_count", 0);
        }
        msv_assign_data("search_str", $_REQUEST['keyword']);
        // запись в таблицу результатов запросов    
            	$item = array(
            		"ip" => msv_get_ip(),
            		"search_txt" => $_REQUEST['keyword'],
            		"count" => (count($module_search)>0? 1:0),
            		"published" => 1,
            	);
        	    $result = db_add(TABLE_SEARCH, $item);
        // запись в таблицу результатов запросов    
    }
}

function Install_Search($module) {
    $themeName = msv_get_config("theme_active");

    $itemStructure = array(
        "url" => $module->baseUrl,
        "name" => "Site Search",
        "template" => $themeName,
        "page_template" => "site-search.tpl",
        "sitemap" => 1,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

}
