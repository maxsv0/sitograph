#!/bin/bash

echo "Updating sitograph"

git pull

cp -ar src/.  /var/www/html
cp -ar src/templates/default/.  /var/www/html/templates/custom/

chown -R devftp:www-data /var/www
find /var/www/html -type d -exec chmod 775 {} \;
find /var/www/html -type f -exec chmod 664 {} \;
