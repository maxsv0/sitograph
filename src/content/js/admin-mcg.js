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


