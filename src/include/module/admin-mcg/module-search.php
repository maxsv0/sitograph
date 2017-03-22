<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27.01.2017
 * Time: 8:26
 */
 
if (isset($_GET['search'])) {
    $module_search = array();
    $module_search_num =array();
    if (!empty($_GET['search']) && empty ($_POST['keyword'])) {
          $_POST['keyword'] = trim($_GET['search']); 
    }

    if (!empty($_POST['keyword'])) {
           $_POST['keyword'] = trim($_POST['keyword']);
           
           $search = array ("'<script[^>]*?>.*?</script>'si",  // Вырезает javaScript
                 "'<[\/\!]*?[^<>]*?>'si",           // Вырезает HTML-теги
                 "'([\r\n])[\s]+'",                 // Вырезает пробельные символы
                 "'&(quot|#34);'i",                 // Заменяет HTML-сущности
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'i"); 
                 
           $_POST['keyword'] = strip_tags(preg_replace($search,"",$_POST['keyword']));
           $tables_info = MSV_get("website.tables");
          
           foreach ($tables_info as $v=>$db_tables_info) {
                    $filter ='';
                    $field_list = array();
                    
                    foreach ($db_tables_info['fields'] as $field=>$attr) {
                         $is_title = 0;
                         $is_text =0;
                         switch ($attr['type']) {
                           case 'str': $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
                                       $field_list[] =$field;
                                      break;
                           case 'text':$filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
                                       $field_list[] =$field; 
                                      break;
                           case 'doc' : $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
                                       $field_list[] =$field;
                                      break;             
                         }
                       
                     }
                 
                
                     if (!empty($field_list)) {
                         $title ='';
                         $filter = substr($filter,0,-2);
                         $field_str = implode(',',$field_list);
                         $sqlCode = "select * from ".$v." where (".$filter.") and `lang`='".LANG."'";
                         $result = API_SQL($sqlCode);
                         if (!$result["ok"]) {
                        		API_callError($result["msg"]);
                         }
                         
                         if (!empty($menu_ar[$db_tables_info['name']]['name'])) {
                            $title = $menu_ar[$db_tables_info['name']]['name'];
                            $url = $menu_ar[$db_tables_info['name']]['url'];
                         } else {
                                foreach ($menu_ar as $si=>$item) {
                                   if (!empty($item['submenu'])) {
                                     foreach($item['submenu'] as $sub=>$tbl) {
                                        if ($tbl['table'] == $db_tables_info['name']) {
                                            $title = $tbl['name'];
                                            $url = $tbl['url'];
                                        }
                                     }
                                   }
                                    
                                }
                         }
                         $index_name = $title;
                      //   var_dump($v);
                         $title = highlight($_POST['keyword'], $title, 10);
                         $i=0;
                         while ($row = MSV_SQLRow($result["data"])) {
                                $ar2 = array();
                                
                                $ar2["title"] = $title;
                                $text = "";
                                foreach ($field_list as $field) {
                                 //   $text .="Поле:".$field." ".$row[$field];
                                   if (strpos(strtoupper($row[$field]), strtoupper($_POST['keyword'])) === false) {
                                      continue;
                                   } else {
                                     $text .=$row[$field]." ";   
                                   }
                                }
                                $a = strpos($text, $_POST['keyword']);
                                if ($a < 300) {
                                    $a = 300;
                                } 
                                $text = strip_tags($text);
                                $text = substr($text, $a - 300, 300);
                                $text = strip_tags($text);
                                
                                $ar2["text"] = highlight($_POST['keyword'], $text, 50);
                                $ar2["url"] = $url."&edit=".$row["id"];
                                $i++;                          
                           $module_search[$index_name][]=$ar2;
                         }
                         if (!empty($index_name)) {
                         $module_search_num[$index_name]= $i;
                         }
                     }  
           }    
           
       } 
      if (!empty($module_search)) {
           MSV_assignData("module_search", $module_search);
           MSV_assignData("module_search_num", $module_search_num); 
      }
      
      MSV_assignData("search", 1); 
       
} 
 
/*
function highlight($s, $text, $c) {
	$text = strip_tags($text);
	$text = str_replace(array("&nbsp;","\n"), " ", $text);
	$text = array_map("trim", explode(" ", $text));
	
	$i = 0;
	$i_pos = 0;
	foreach ($text as $v) {
		if (!empty($v)) {
			$ar[] = $v;
			if (strstr($v, $s) && empty($i_pos)) $i_pos = $i;
			$i++;
		}
	}
	$i_pos = ($i_pos - $c) < 0 ? 0 : $i_pos - $c;
	for ($i = $i_pos; $i < ($c * 2 + $i_pos); $i++) {
		if (!empty($ar[$i])) $ar2[] = $ar[$i];
	}
	unset($ar);
   // var_dump(str_replace($s, "<strong>".$s."</strong>", implode(' ', $ar2)));
    // Создаем строку для регулярного выражения
    $pattern = "/((?:^|>)[^<]*)(".$s.")/si";
    // Подсвеченная строка
    $replace = '$1<b>$2</b>';
    
	return (empty($ar2) ? "" :  preg_replace($pattern, $replace, implode(' ', $ar2)));
}
*/


?>