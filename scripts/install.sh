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
echo "Permissions set www-data:www-data"
