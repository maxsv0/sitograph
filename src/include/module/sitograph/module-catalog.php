<?php


    if (!empty($_POST['load_catalog']) && !empty($_FILES['catalog']["tmp_name"])) {
        var_dump($_POST);
        var_dump($_FILES);
        //die;
        // Загрузка файла
      $file = msv_store_pic($_FILES["catalog"]["tmp_name"],'xml');
         if ($file > 0) {
            $loadedfile = UPLOAD_FILES_PATH."/".$file;
            
            $resultQuery = db_get_list(TABLE_RODS_FORMATION, "");
        	if (!$resultQuery["ok"]) {
                msv_message_error($result["msg"]);
        	} 
            
            $formation_type = array();
            
        	foreach ($resultQuery['data'] as $v=>$k) {
        		$formation_type[$k['name']] = $k['id'];
        	}
            
            $upload_data = array();
            
            $rods_cat = array(201);
            
            $reels_cat = array(574);
            
           
            $content = simplexml_load_file($loadedfile);
           
            foreach ($content->shop->offers->offer as $items) {
               $data = array();
               if (in_array((int)$items->categoryId,$rods_cat)) { // заргузка спиннингов
                
                foreach ($items->prop as $v) {
                    $attributes = $v->attributes();
        			$name = (string)$attributes["name"];
                    
        			switch ($name) {
        			 //case 'Тип удилища': $data['class_id'] = $rods_type[(string)$v];
//                                         break;
                     case 'Длина, м':    $data['width'] = (float)$v;
                                         break;
                     case 'Тест, г':     $str = (string)$v;
                                         if (!empty($str)) {
                                             $test = explode(',',$str);
                                             $d = explode('-', $test[0]);
                                             $data['test_w_min'] = $d[0];    
                                             $data['test_w_max'] = $d[1];    
                                         }
                                         break; 
                     case 'Тест, lb':    $str = (string)$v;
                                         if (!empty($str)) {
                                             $test = explode(',',$str);
                                             $d = explode('-', $test[0]);
                                             $data['test_lb_min'] = $d[0];    
                                             $data['test_lb_max'] = $d[1];    
                                         }
                                         break;
                     case 'Вес, г':    $data['weight'] = (int)$v;
                                         break; 
                     case 'Количество секций':    $str = (string)$v;
                                         if (!empty($str)) {
                                             $test = explode('+',$str);
                                             $data['count_sections'] = $test[0];    
                                         }
                                         break; 
                     case 'Траспортировочная длина, м':    $data['transport_length'] = (int)$v;
                                         break;   
                     case 'Строй': $data['formation_id'] = $formation_type[(string)$v];
                                        
                                         break;                                                                                                                                      
        			}	
                      
                } // свойства
                 
                 $data['name'] =(string)$items->name;
                 $data['code_name'] =(string)$items->vendorCode;
                 $description =(string)$items->description;
                // var_dump($description);
                 $data['price'] =(int)$items->price;
                 $attributes = $items->attributes();
                 $data['product_code'] =(int)$attributes["productId"];
                 if ((string)$attributes["available"] =='true') {
                    $data['available'] = 1;
                 }
                 $data['published'] = 1;
                 $data['updated'] = date("Y-m-d H:i:s");
                 $data['lang'] = 'ru';
                 $data['author'] = $_SESSION["user_email"];
                 
                 $result = db_get(TABLE_RODS_MODELS, " `product_code` = '".$data['product_code']."'");
                 if ($result["ok"] && !empty($result["data"])) {
                    $sqlCode = "update `".TABLE_RODS_MODELS."`  ";
                	$sqlCode .= " set ";
                	$sqlCode .= " `price` = '".$data['price']."', ";
                	$sqlCode .= " `updated` = '".$data['updated']."', ";
                	$sqlCode .= " `author` = '".$data['author']."', ";
                	$sqlCode .= " `available` = '".$data['available']."' ";
                	$sqlCode .= " where";
                	$sqlCode .= " `product_code` = '".$data['product_code']."'";
                    
                   	$result_update = db_sql($sqlCode);
                    //var_dump($data['price']);
                	if (!$result_update["ok"]) {
                        msv_message_error($result_update["msg"]);
                	}
                    // проверка таблицы удилища
                    
                    if ($result["data"]["rods_id"] > 0) {
                       $result_roads = db_get(TABLE_RODS, " `id` = '".$result["data"]["rods_id"]."'");
                      
                       if ($result_roads["ok"] && !empty($result_roads["data"])) {
                         
                         // характеристики (описание)
                         
                         if (empty($result_roads["data"]["text"]) && !empty($description)) {
                           // var_dump($description);
                            $description = '<p>'.$description.'</p>';
                             
                            
                            $sqlCode = "update `".TABLE_RODS."`  ";
                        	$sqlCode .= " set ";
                        	$sqlCode .= " `text` = '".$description."', ";
                        	$sqlCode .= " `updated` = '".$data['updated']."', ";
                        	$sqlCode .= " `author` = '".$data['author']."' ";
                        	$sqlCode .= " where";
                        	$sqlCode .= " `id` = '".$result["data"]["rods_id"]."'";
                            
                           	$result_update = db_sql($sqlCode);
                           
                         }
                       } 
                    }
                    // проверка таблицы удилища
                    
                 } else {
                    $insert_result = db_update_row(TABLE_RODS_MODELS, $data);
                    if (!$insert_result["ok"]) {
                        msv_message_error($result["msg"]);
                	}
                 }
        
               } // загрузка спиннингов
               elseif (in_array((int)$items->categoryId,$reels_cat)) { // грузим катушки
       /////////////////////////////////////////////////////////////////////////////////////
                       foreach ($items->prop as $v) {
                                    $attributes = $v->attributes();
                        			$name = (string)$attributes["name"];
                                    
                        			switch ($name) {

                                     case 'Типоразмер':  $data['type_size'] = (int)$v;
                                                         break;
                                     case 'Лесоемкость': $data['fishing_line'] = (string)$v;
                                                         break;
                                     case 'Количество подшипников':    $data['bearings_num'] = (string)$v;
                                                         break;
                                     case 'Передаточное число':    $data['gear_ratio'] = (string)$v;
                                                         break; 
                                     case 'Вес, г':    $data['weight'] = (string)$v;
                                                         break;                                                                                                                                   
                        			}	
                                      
                                } // свойства
                                 
                                 $data['name'] =(string)$items->name;
                                 $data['code_name'] =(string)$items->vendorCode;
                                 $description =(string)$items->description;
                                // var_dump($description);
                                 $data['price'] =(int)$items->price;
                                 $attributes = $items->attributes();
                                 $data['product_code'] =(int)$attributes["productId"];
                                 if ((string)$attributes["available"] =='true') {
                                    $data['available'] = 1;
                                 }
                                 $data['published'] = 1;
                                 $data['updated'] = date("Y-m-d H:i:s");
                                 $data['lang'] = 'ru';
                                 $data['author'] = $_SESSION["user_email"];
                                 
                                 $result = db_get(TABLE_REELS_MODELS, " `product_code` = '".$data['product_code']."'");
                                 if ($result["ok"] && !empty($result["data"])) {
                                    $sqlCode = "update `".TABLE_REELS_MODELS."`  ";
                                	$sqlCode .= " set ";
                                	$sqlCode .= " `price` = '".$data['price']."', ";
                                	$sqlCode .= " `updated` = '".$data['updated']."', ";
                                	$sqlCode .= " `author` = '".$data['author']."', ";
                                	$sqlCode .= " `available` = '".$data['available']."' ";
                                	$sqlCode .= " where";
                                	$sqlCode .= " `product_code` = '".$data['product_code']."'";
                                    
                                   	$result_update = db_sql($sqlCode);
                                    //var_dump($data['price']);
                                	if (!$result_update["ok"]) {
                                        msv_message_error($result_update["msg"]);
                                	}
                                    // проверка таблицы катушки 
                                    
                                    if ($result["data"]["reels_id"] > 0) {
                                       $result_roads = db_get(TABLE_REELS, " `id` = '".$result["data"]["reels_id"]."'");
                                      
                                       if ($result_roads["ok"] && !empty($result_roads["data"])) {
                                         
                                         // характеристики (описание)
                                         
                                         if (empty($result_roads["data"]["text"]) && !empty($description)) {
                                           
                                            $description = '<p>'.$description.'</p>';
                                             
                                            
                                            $sqlCode = "update `".TABLE_REELS."`  ";
                                        	$sqlCode .= " set ";
                                        	$sqlCode .= " `text` = '".$description."', ";
                                        	$sqlCode .= " `updated` = '".$data['updated']."', ";
                                        	$sqlCode .= " `author` = '".$data['author']."' ";
                                        	$sqlCode .= " where";
                                        	$sqlCode .= " `id` = '".$result["data"]["reels_id"]."'";
                                            
                                           	$result_update = db_sql($sqlCode);
                                           
                                         }
                                       } 
                                    }
                                    // проверка таблицы катушки
                                    
                                 } else {
                                    $insert_result = db_update_row(TABLE_REELS_MODELS, $data);
                                    if (!$insert_result["ok"]) {
                                        msv_message_error($result["msg"]);
                                	}
                                 }
       /////////////////////////////////////////////////////////////////////////////////////         
               }
                 
            } // foreach - крутим файл загрузки
            unlink($loadedfile);
         //   MSV_redirect("/admin/?section=".$_REQUEST["section"]."&saved");    
        } // load file        
    } // загрузка 



?>