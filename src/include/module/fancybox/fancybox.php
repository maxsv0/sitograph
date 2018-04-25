<?php

msv_include(CONTENT_URL."/css/jquery.fancybox.css");
msv_include(CONTENT_URL."/js/jquery.fancybox.min.js");

msv_include_js("
   $('[rel=\"fancybox\"]').fancybox({
    		'transitionIn'	:	'elastic',
    		'transitionOut'	:	'elastic',
    		'speedIn'		:	600, 
    		'speedOut'		:	200, 
    		'overlayShow'	:	true,
            'overlayOpacity':   0.2
    	});
");