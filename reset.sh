#!/bin/bash

echo "RESET MSV"

rm -R src/include/custom/smarty/cache/*.tpl.php

echo "remove cropper" 
rm -R src/include/module/cropper/
rm src/content/css/jquery.cropper.css
rm src/content/js/jquery.cropper.js

echo "remove fancybox" 
rm -R src/include/module/fancybox/
rm src/content/css/jquery.fancybox.css
rm src/content/js/jquery.fancybox.min.js

echo "remove fancybox" 
rm -R src/include/module/tinymce/
rm -R src/content/js/tinymce

echo "remove isotope" 
rm -R src/include/module/isotope/

mv src/include/module/-install/ src/include/module/install/

find . -name '*.DS_Store' -type f -delete

cp config-sample.php src/config.php