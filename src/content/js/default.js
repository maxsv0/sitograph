jQuery(document).ready(function() {
    // add slidedown animation
    $('.dropdown').on('show.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(200);
    });

    // add slideup animation
    $('.dropdown').on('hide.bs.dropdown', function(e){
        e.preventDefault();
        $(this).removeClass('open');
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(400, function(){
            //On Complete, we reset all active dropdown classes and attributes
            //This fixes the visual bug associated with the open class being removed too fast
            $('.dropdown').find('.dropdown-toggle').attr('aria-expanded','false');
        });
    });

    $(".module-block").click(function (){

    	if ($(this).find(".module-preview").attr("src")) {
            $("#moduleModal").find(".module-preview").attr("src", $(this).find(".module-preview").attr("src"));
		} else {
            $("#moduleModal").find(".module-preview").attr("src", "about:blank");
		}

        $("#moduleModal").find(".module-title").html($(this).find(".module-title").html());
        $("#moduleModal").find(".module-tags").html($(this).find(".module-tags").html());
        $("#moduleModal").find(".module-postdate").html($(this).find(".module-postdate").html());
        $("#moduleModal").find(".module-star-rating").html($(this).find(".module-star-rating").html());
        $("#moduleModal").find(".module-downloads").html($(this).find(".module-downloads").html());
        $("#moduleModal").find(".module-reviews").html($(this).find(".module-reviews").html());
        $("#moduleModal").find(".module-price").html($(this).find(".module-price").html());
        $("#moduleModal").find(".module-description").html($(this).find(".module-description").html());
        $("#moduleModal").find(".module-buildinfo").html($(this).find(".module-buildinfo").html());
        $("#moduleModal").find(".module-btnload").html($(this).find(".module-btnload").html());
        $("#moduleModal").find(".module-buildfiles").html($(this).find(".module-buildfiles").html());
        $("#moduleModal").find(".module-btnload").attr("href", $(this).find(".module-btnload").attr("href"));
        $("#moduleModal").find(".module-btnpage").attr("href", $(this).find(".module-btnpage").html());
        $("#moduleModal").find(".module-btnadd").val($(this).find("input[name='module_name[]']").val());
        $("#moduleModal").find(".module-name").html($(this).find("input[name='module_name[]']").val());

        $("#moduleModal").find(".module-btnadd").click(function() {
            alert("Go to Admin -> Module Settings and click 'install new' -> click '"+$(this).val()+"' -> click 'install'\n" +
                "OR paste a code at a Sitograph Terminal");
        });

        $("#moduleModal").modal();
    });

});