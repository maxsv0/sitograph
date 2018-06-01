#!/bin/bash

if [ -z "$1" ]
  then
    echo "Please specify installation path"
	exit
fi

echo "Installing Sitograph to $1"
cp -ar src/.  $1
cp -ar src/templates/default/.  $1/templates/custom/

chown -R www-data:www-data $1
echo "Permissions set to www-data:www-data for $1"

echo "Enable Apache configuration sitograph.conf and modules (rewrite headers expires deflate pagespeed)"
cp scripts/sitograph.conf  /etc/apache2/conf-available/
a2enconf sitograph
a2enmod rewrite headers expires deflate pagespeed
service apache2 restart

echo "Install finished"