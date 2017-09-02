#!/bin/bash

echo "RESET MSV"

rm -R ../src/include/custom/smarty/cache/*.tpl.php

find . -name '*.DS_Store' -type f -delete

echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">

</urlset>'>src/sitemap.xml