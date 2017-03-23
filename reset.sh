#!/bin/bash

echo "RESET MSV"

rm -R src/include/custom/smarty/cache/*.tpl.php

find . -name '*.DS_Store' -type f -delete

cp config-sample.php src/config.php

echo ''>src/sitemap.xml