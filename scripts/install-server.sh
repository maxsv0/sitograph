#!/bin/bash

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 
   exit 1
fi

add-apt-repository universe
apt-get -y update 

# install utils
apt-get -y install debconf-utils unzip wget pwgen

# generate passwords
MASTER_PASS=$(pwgen -c -1 12)
DB_PASS=$(pwgen -c -1 12)
ADMIN_PASS=$(pwgen -c -1 12)

# Install LAMP stack
echo "mysql-server mysql-server/root_password password $MASTER_PASS" | sudo debconf-set-selections
echo "mysql-server mysql-server/root_password_again password $MASTER_PASS" | sudo debconf-set-selections
apt-get -y install lamp-server^

# Install CMS dependency
phpversion="$(php --version | head -n 1 | cut -d " " -f 2 | cut -c 1,3)"
if [ $phpversion -lt 70 ]
then
	apt-get -y install php5-gd php5-curl
else
    apt-get -y install php7.0-xml php7.0-zip php7.0-gd php7.0-mbstring php-curl
fi

# install Mod PageSpeed
if [ `getconf LONG_BIT` = "64" ]
then
    wget https://dl-ssl.google.com/dl/linux/direct/mod-pagespeed-stable_current_amd64.deb
else
    wget https://dl-ssl.google.com/dl/linux/direct/mod-pagespeed-stable_current_i386.deb
fi
dpkg -i mod-pagespeed-*.deb
# clean up
rm mod-pagespeed-*.deb

# Download latest version of Sitograph and upzip folder
wget https://github.com/maxsv0/sitograph/archive/v1.1.zip -O sitograph-v1.1.zip
unzip sitograph-v1.1.zip
cd sitograph-1.1

# Copy Sitograph files and enable Apache configuration
sh scripts/install.sh /var/www/html

# Create MySQL database
sh scripts/mysqlcreate.sh root $MASTER_PASS sitograph $DB_PASS

# done!
echo "Sitograph CMS Environment"
echo "--------------------------------------------"
echo "Mysql Root password: $MASTER_PASS"
echo "Mysql Sitograph user: sitograph"
echo "Mysql Sitograph user password: $DB_PASS"
echo "--------------------------------------------"
echo "Install Successful."

