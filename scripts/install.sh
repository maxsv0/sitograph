#!/bin/bash

if [ -z "$1" ]
  then
    echo "Please specify installation path"
	exit
fi

echo "Installing Sitograph to $1"
cp -ar ../src/.  $1
chown -R www-data:www-data $1
cp -ar ../src/templates/default/.  $1/templates/custom/

cp -ar ../src/. $1

echo "Files were copied successfully"