<?php

MSV_Include("/content/css/jquery.fancybox.css");
MSV_Include("/content/js/jquery.fancybox.min.js");

MSV_IncludeJS("
   $('[rel=\"fancybox\"]').fancybox({
    		'transitionIn'	:	'elastic',
    		'transitionOut'	:	'elastic',
    		'speedIn'		:	600, 
    		'speedOut'		:	200, 
    		'overlayShow'	:	true,
            'overlayOpacity':   0.2
    	});
");