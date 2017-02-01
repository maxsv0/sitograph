$(document).ready(function() {
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('.tab-content').resize();
    })
     
    // Меню админки
    $("#menu_left div a").each(function() {
        var div = $(this).parent();
       
        if (div.hasClass("mod_box") || div.hasClass("mod_box_active")) {
            $(this).click(function() {
                div.attr("class",(div.hasClass("mod_box") ? "mod_box_active" : "mod_box"));
                div.find("div a").each(function() {
                    $(this).find("p").removeAttr("style").css({"padding-top": parseInt(($(this).height() - $(this).find("p").height()) / 2) + "px"});
                    $(this).parent().find("img").css({"left": $(this).parent().width() + "px"});
                    $(this).parent().find("img").attr("src","/content/images/adminmcg/menu_h33px.gif");
                });
            });
        }
    });
    
   // скрыть подразделы в структуре сайта 
   if ($("#structure-table").size()>0) {
       $("#structure-table tr").each(function(){
        if ($(this).data("level")>0) {
            $(this).hide();
        }
        
       }); 
   } 
   // скрыть подразделы в структуре сайта 
    
});

function textCounter( field, countfield, maxlimit ) {
  var block_num = field.id.substring(10);
  if ( field.value.length > maxlimit )
  {
    field.value = field.value.substring( 0, maxlimit );
    document.getElementById("message-text-counter"+block_num).innerHTML = "<span style='color:red;'>Текст не может быть длиннее&nbsp;"+maxlimit+"&nbsp;символов</span>";
    return false;
  }
  else
  {
    document.getElementById("message-text-counter"+block_num).innerHTML = '<div id="message-text-counter'+block_num+'">Осталось&nbsp;символов&nbsp;-&nbsp;<span id="text-counter'+block_num+'"></span></div>';
    document.getElementById(countfield).innerHTML = maxlimit - field.value.length;
  }
}  


var active_block = 0;

function change_view(x) {
    var d = document.getElementById("block_title_"+x);
    var t = document.getElementById("block_text_"+x);
    
    if (d.className == "block_title") {
        d.className = "block_title_a";
        t.style.display = "block";

        if (active_block != 0) {
            change_view(active_block);
        }
        active_block = x;
    } else {
        d.className = "block_title";
        t.style.display = "none";
        
        active_block = 0;
    }
}
function open_all() {
    i = 1;
    var d = document.getElementById("block_title_"+i);
    var t = document.getElementById("block_text_"+i);
    while (d && t) {
        d.className = "block_title_a";
        t.style.display = "block";
        
        i++;
        var d = document.getElementById("block_title_"+i);
        var t = document.getElementById("block_text_"+i);
    }
    $("#search_toogle").html("<a href='javascript:close_all();'>Свернуть все</a>");
}
function close_all() {
    i = 1;
    var d = document.getElementById("block_title_"+i);
    var t = document.getElementById("block_text_"+i);
    while (d && t) {
        d.className = "block_title";
        t.style.display = "none";
        
        i++;
        var d = document.getElementById("block_title_"+i);
        var t = document.getElementById("block_text_"+i);
    }
     $("#search_toogle").html("<a href='javascript:open_all();'>Развернуть все</a>");
}

function toogle_parent(e,id, level) {
    
    if ($(e).parent().parent().hasClass('selected')) {
        $(e).parent().parent().removeClass('selected');
        $("#block_"+id).attr("src","/content/images/adminmcg/arrow_right.png");
        $("#structure-table tr").each(function(){
            if ($(this).data("index") == id && $(this).data("level")== parseInt(level)+1) {
                $(this).hide();
            }
         });
    } else {
        $(e).parent().parent().addClass('selected');
        $("#block_"+id).attr("src","/content/images/adminmcg/arrow_down.png");
         $("#structure-table tr").each(function(){
             
            if ($(this).data("index") == id && $(this).data("level") == parseInt(level)+1) {
               
                $(this).show();
            }
         });
    }

    
}