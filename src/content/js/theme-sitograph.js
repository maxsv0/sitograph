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

    // load inline editor in 0.1 sec after page is loaded
    setTimeout(function() {
       // add top promo animation
        var index = 0;
        var promo_img = [];
        var promo_img_deg = [];

        function rotate(obj, degree, timer, acc) {
            obj.css({ WebkitTransform: 'rotate(' + degree + 'deg)'});
            obj.css({ '-moz-transform': 'rotate(' + degree + 'deg)'});
            obj.css('transform','rotate('+degree+'deg)');
            timer = setTimeout(function() {
                degree = degree - acc;
                acc = acc + 1;
                if (degree > 0) {
                    rotate(obj, degree, timer, acc);
                } else {
                    rotate(obj, 0, timer, 0);
                }
            },3);
        }

        $('.img-promo').each(function(e){
            promo_img[index] = $(this);
            promo_img_deg[index] = Math.floor((Math.floor(Math.random() * 25) + 60)*index);

            var timer;
            rotate(promo_img[index], promo_img_deg[index], timer, 1);

            $(this).fadeIn(250*index);
            index++;
        });
    }, 100);

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

function animate_promo() {
    $('.img-promo-spin-4').each(function(){
        $(this).removeClass("img-promo-spin-4").addClass("img-promo-spin-2");
    });
    $('.img-promo-spin-3').each(function(){
         $(this).removeClass("img-promo-spin-3").addClass("img-promo-spin-0");
    });
    $('.img-promo-spin-2').each(function(){
        $(this).removeClass("img-promo-spin-2").addClass("img-promo-spin-0");
    });
    $('.img-promo-spin-1').each(function(){
        $(this).removeClass("img-promo-spin-1").addClass("img-promo-spin-3");
    });
    $('.img-promo-spin-0').each(function(){
        $(this).removeClass("img-promo-spin-0").addClass("img-promo-spin-1");
    });
}