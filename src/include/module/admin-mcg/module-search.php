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
           
           $_SESSION['search_keyword'] = $_POST['keyword'];
            // таблица структура и документы 
            
            $resultQuery = API_getDBList('structure', "`name` like '%".$_POST['keyword']."%' and `published`='1' ");
            if (!$resultQuery["ok"]) {
        		API_callError($result["msg"]);
        	}
            
                      
            $i=0;
            foreach ($resultQuery['data'] as $v=>$k) {
                    $result = API_getDBItem('documents', " `id` = '".$k['page_document_id']."'");
                    
                    $ar2 = array();
                    $ar2["title"] = highlight($_POST['keyword'], $k["name"], 10);
                    
                    $result["data"]["text"] = strip_tags($result["data"]["text"]);        
                    $a = strpos($result["data"]["text"], $_POST['keyword']);
                    if ($a === false) {
                        $a = 300;
                    } 
        
                    $result["data"]["text"] = substr($result["data"]["text"], $a - 300, $a + 300);
                    $result["data"]["text"] = strip_tags($result["data"]["text"]);
        
                    $ar2["text"] = highlight($_POST['keyword'], $result["data"]["text"], 50);
                    $ar2["url"] = "/admin/?section=structure&table=structure&edit=".$k["id"];
                    $i++;
            $module_search[$menu_ar["structure"]['name']][]=$ar2;       
            }
            $module_search_num[$menu_ar["structure"]['name']]= $i;

       // пользовательские модули 
          $tables_info = MSV_get("website.tables");
        //    var_dump($tables_info); 
           foreach (MSV_get("website.modules") as $v=>$m_name) {
                 $db_tables_info = $tables_info[$m_name];
                 
//                 load_module_config($m_name);
//                foreach ($db_tables_info as $v=>$k) {
//                    $table_structure = $db_info[$v];
//                    $filter ='';
//                    $field_list = array();
//                    foreach ($table_structure as $field=>$attr) {
//                         $is_title = 0;
//                         $is_text =0;
//                         $temp_ar = explode("|",$attr['type']);
//                         switch ($temp_ar[0]) {
//                           case 'str': $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
//                                       $field_list[] =$field;
//                                      break;
//                           case 'text':$filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
//                                       $field_list[] =$field; 
//                                      break;
//                           case 'wysiwyg' : $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
//                                       $field_list[] =$field;
//                                      break;             
//                         }
//                       //var_dump($filter); 
//                     }
//                     if (!empty($field_list)) {
//                         $filter = substr($filter,0,-2);
//                         $field_str = implode(',',$field_list);
//                         $sql_query = "select * from ".$v." where ".$filter."";
//                      //   var_dump($sql_query);
//                         $i=0;   
//                         $query = mysql_query($sql_query);
//                             while ($row =  mysql_fetch_assoc($query)) {
//                                $ar2 = array();
//                                $title = $k;
//                                $ar2["title"] = highlight($title, array($_POST['keyword']));
//                                $text = "";
//                                foreach ($field_list as $field) {
//                    //                $text .="Поле:".$field." ".$row[$field];
//                                   if (strpos(strtoupper($row[$field]), strtoupper($_POST['keyword'])) === false) {
//                                      continue;
//                                   } else {
//                                     $text .=$row[$field]." ";   
//                                   }
//                                }
//                                $a = strpos($text, $_POST['keyword']);
//                                if ($a < 300) {
//                                    $a = 300;
//                                } 
//                                $text = strip_tags($text);
//                                $text = substr($text, $a - 300, 300);
//                                $text = strip_tags($text);
//
//                                $ar2["text"] = highlight($text, array($_POST['keyword']));
//                                $ar2["url"] = "/admin/?module=".$m_name."&table=".$v."&item_id=".$row['id']."&edit=edit";
//                                $i++;
//                           $module_search[$k][]=$ar2; 
//                           }
//                          $module_search_num[$k] = $i; 
//                     }                     
//                }  
           }            
            
            
           // var_dump(MSV_get("website.modules"));
//   // системные сообщения
//             $sql_query = "select * from messages where text like '%".$_POST['keyword']."%'";
//          //   var_dump($sql_query);
//             $i=0;
//             $query = mysql_query($sql_query);
//                 while ($row =  mysql_fetch_assoc($query)) {
//                    $ar2 = array();
//                    $ar2["title"] = "Системное сообщение";
//                    $text = $row['text'];
//                    $a = strpos($text, $_POST['keyword']);
//                    if ($a < 300) {
//                        $a = 300;
//                    } 
//                    $text = strip_tags($text);
//                    $text = substr($text, $a - 300, 300);
//                    $text = strip_tags($text);
//
//                    $ar2["text"] = highlight($text, array($_POST['keyword']));
//                    $ar2["url"] = "/admin/?module=messages&item_id=".$row['message_id']."&edit=edit";
//                    $i++;
//                    $module_search['Системные сообщения'][]=$ar2;     
//             }   
//      $module_search_num['Системные сообщения'] = $i;
//   // системные сообщения            
//       // пользовательские модули    
//           foreach ($cfg_modules as $m_name) {
//                 $db_tables_info = array();
//                 load_module_config($m_name);
//                foreach ($db_tables_info as $v=>$k) {
//                    $table_structure = $db_info[$v];
//                    $filter ='';
//                    $field_list = array();
//                    foreach ($table_structure as $field=>$attr) {
//                         $is_title = 0;
//                         $is_text =0;
//                         $temp_ar = explode("|",$attr['type']);
//                         switch ($temp_ar[0]) {
//                           case 'str': $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
//                                       $field_list[] =$field;
//                                      break;
//                           case 'text':$filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
//                                       $field_list[] =$field; 
//                                      break;
//                           case 'wysiwyg' : $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
//                                       $field_list[] =$field;
//                                      break;             
//                         }
//                       //var_dump($filter); 
//                     }
//                     if (!empty($field_list)) {
//                         $filter = substr($filter,0,-2);
//                         $field_str = implode(',',$field_list);
//                         $sql_query = "select * from ".$v." where ".$filter."";
//                      //   var_dump($sql_query);
//                         $i=0;   
//                         $query = mysql_query($sql_query);
//                             while ($row =  mysql_fetch_assoc($query)) {
//                                $ar2 = array();
//                                $title = $k;
//                                $ar2["title"] = highlight($title, array($_POST['keyword']));
//                                $text = "";
//                                foreach ($field_list as $field) {
//                    //                $text .="Поле:".$field." ".$row[$field];
//                                   if (strpos(strtoupper($row[$field]), strtoupper($_POST['keyword'])) === false) {
//                                      continue;
//                                   } else {
//                                     $text .=$row[$field]." ";   
//                                   }
//                                }
//                                $a = strpos($text, $_POST['keyword']);
//                                if ($a < 300) {
//                                    $a = 300;
//                                } 
//                                $text = strip_tags($text);
//                                $text = substr($text, $a - 300, 300);
//                                $text = strip_tags($text);
//
//                                $ar2["text"] = highlight($text, array($_POST['keyword']));
//                                $ar2["url"] = "/admin/?module=".$m_name."&table=".$v."&item_id=".$row['id']."&edit=edit";
//                                $i++;
//                           $module_search[$k][]=$ar2; 
//                           }
//                          $module_search_num[$k] = $i; 
//                     }                     
//                }  
//           }
           
       } 
      if (!empty($module_search)) {
           MSV_assignData("module_search", $module_search);
           MSV_assignData("module_search_num", $module_search_num); 
      }
      
      MSV_assignData("search", 1); 
       
} 
 

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

 

/*    if (isset($_GET['search'])) {
       $module_search = array();
       $module_search_num =array(); 
       if (!empty($_GET['search']) && empty ($_POST['keyword'])) {
          $_POST['keyword'] = trim($_GET['search']); 
       }
       if (!empty($_POST['keyword'])) {
           $_POST['keyword'] = trim($_POST['keyword']);
           $_SESSION['search_keyword'] = $_POST['keyword'];
    // таблица структура и документы   
    $query = mysql_query("select * from site_structure where ss_title like '%".mysql_escape_string($_POST['keyword'])."%' and ss_active > 0");
    $i=0;
    while ($row =  mysql_fetch_assoc($query)) {
            $row2 = mysql_fetch_array(mysql_query("select * from documents where d_id = ".$row["ss_document_id"]));
            
            $ar2 = array();
            $ar2["title"] = highlight($row["ss_title"], array($_POST['keyword']));
            $row2["d_text"] = strip_tags($row2["d_text"]);        
            $a = strpos($row2["d_text"], $_POST['keyword']);
            if ($a === false) {
                $a = 300;
            } 
    //        var_dump($row2["d_text"]);

            $row2["d_text"] = substr($row2["d_text"], $a - 300, $a + 300);
            $row2["d_text"] = strip_tags($row2["d_text"]);

            $ar2["text"] = highlight($row2["d_text"], array($_POST['keyword']));
            $ar2["url"] = "/admin/?module=structure&lang=".$row["ss_lang"]."&item_id=".$row["ss_id"]."&edit=edit";
            $i++;
    $module_search['Структура сайта'][]=$ar2;       
    }
    $module_search_num['Структура сайта']= $i;
   // системные сообщения
             $sql_query = "select * from messages where text like '%".$_POST['keyword']."%'";
          //   var_dump($sql_query);
             $i=0;
             $query = mysql_query($sql_query);
                 while ($row =  mysql_fetch_assoc($query)) {
                    $ar2 = array();
                    $ar2["title"] = "Системное сообщение";
                    $text = $row['text'];
                    $a = strpos($text, $_POST['keyword']);
                    if ($a < 300) {
                        $a = 300;
                    } 
                    $text = strip_tags($text);
                    $text = substr($text, $a - 300, 300);
                    $text = strip_tags($text);

                    $ar2["text"] = highlight($text, array($_POST['keyword']));
                    $ar2["url"] = "/admin/?module=messages&item_id=".$row['message_id']."&edit=edit";
                    $i++;
                    $module_search['Системные сообщения'][]=$ar2;     
             }   
      $module_search_num['Системные сообщения'] = $i;
   // системные сообщения            
       // пользовательские модули    
           foreach ($cfg_modules as $m_name) {
                 $db_tables_info = array();
                 load_module_config($m_name);
                foreach ($db_tables_info as $v=>$k) {
                    $table_structure = $db_info[$v];
                    $filter ='';
                    $field_list = array();
                    foreach ($table_structure as $field=>$attr) {
                         $is_title = 0;
                         $is_text =0;
                         $temp_ar = explode("|",$attr['type']);
                         switch ($temp_ar[0]) {
                           case 'str': $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
                                       $field_list[] =$field;
                                      break;
                           case 'text':$filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
                                       $field_list[] =$field; 
                                      break;
                           case 'wysiwyg' : $filter .=" `".$field."` like '%".$_POST['keyword']."%' or";
                                       $field_list[] =$field;
                                      break;             
                         }
                       //var_dump($filter); 
                     }
                     if (!empty($field_list)) {
                         $filter = substr($filter,0,-2);
                         $field_str = implode(',',$field_list);
                         $sql_query = "select * from ".$v." where ".$filter."";
                      //   var_dump($sql_query);
                         $i=0;   
                         $query = mysql_query($sql_query);
                             while ($row =  mysql_fetch_assoc($query)) {
                                $ar2 = array();
                                $title = $k;
                                $ar2["title"] = highlight($title, array($_POST['keyword']));
                                $text = "";
                                foreach ($field_list as $field) {
                    //                $text .="Поле:".$field." ".$row[$field];
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

                                $ar2["text"] = highlight($text, array($_POST['keyword']));
                                $ar2["url"] = "/admin/?module=".$m_name."&table=".$v."&item_id=".$row['id']."&edit=edit";
                                $i++;
                           $module_search[$k][]=$ar2; 
                           }
                          $module_search_num[$k] = $i; 
                     }                     
                }  
           }
           
       }

   //  var_dump($ar);

    if (!empty($module_search)) {
        echo "<div id='search_toogle' style='padding:0px 20px 15px 5px;text-align:right;'><a href='javascript:open_all();'>Развернуть все</a></div>";   
      $i=1;
      foreach ($module_search as $name=>$ar){
          echo "<div id='block_title_".$i."' class='block_title' onclick='change_view(".$i.")'><span style='color: #800000;'>".$name." (".$module_search_num[$name].")</span></div>";
          echo "<div id='block_text_".$i."' class='block_text'>";
          foreach ($ar as $v) {
              echo "<a href='".$v['url']."'>".$v['title']."</a><br>";
              echo "<p>".$v['text']."</p><br>";
          }
         echo "</div>";
         $i++; 
    }    
    } else { 
     echo "<div style='margin-left:20px;'><b>По вашему запросу ничего не найдено.</b></div>";   
    }
    }

*/ 
?>