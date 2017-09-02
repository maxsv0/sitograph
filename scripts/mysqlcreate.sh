#!/bin/bash

if [ -z "$1" ]
  then
    echo "Enter login to connect to MYSQL"
	exit 0
fi

if [ -z "$2" ]
  then
    echo "Enter password to connect to MYSQL"
	exit 0
fi
  
if [ -z "$3" ]
  then
    echo "Enter database name to create"
	exit 0
fi

dblogin=$1
dbpassword=$2
dbsitograph=$3
dbsitographpassword=$4

if [ -z "$dbsitographpassword" ]
  then
    dbsitographpassword=`cat /dev/urandom | tr -cd '[:alnum:]' | fold -w32 | head -1`
fi

echo "Creating database $dbsitograph and user $dbsitograph"

mysql -h 127.0.0.1 -u$dblogin -p$dbpassword -e "CREATE USER '$dbsitograph'@'localhost' IDENTIFIED BY '$dbsitographpassword';"
mysql -h 127.0.0.1 -u$dblogin -p$dbpassword -e "GRANT USAGE ON *.* TO '$dbsitograph'@'localhost' IDENTIFIED BY '$dbsitographpassword' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;"
mysql -h 127.0.0.1 -u$dblogin -p$dbpassword -e "CREATE DATABASE IF NOT EXISTS $dbsitograph;"
mysql -h 127.0.0.1 -u$dblogin -p$dbpassword -e "GRANT ALL PRIVILEGES ON $dbsitograph.* TO '$dbsitograph'@'localhost';"

echo "DONE!"
echo "Database created: $dbsitograph"
echo "User created: $dbsitograph"
echo "Database password: $dbsitographpassword"