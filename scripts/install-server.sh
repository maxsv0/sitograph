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

# Download latest version of Sitograph and upzip folder
wget https://github.com/maxsv0/sitograph/archive/v1.0.zip -O sitograph-v1.0.zip
unzip sitograph-v1.0.zip
cd sitograph-1.0

# Copy Sitograph files and enable Apache configuration
sh scripts/install.sh /var/www/html

# Create MySQL database
sh scripts/mysqlcreate.sh root $MASTER_PASS sitograph $DB_PASS

# run CMS install
wget -O "result.html" "http://localhost/?install_auto=1&install_step=1&msv_DB_LOGIN=sitograph&msv_DB_PASSWORD=$DB_PASS&msv_DB_NAME=sitograph&msv_LANGUAGES=en&modules_local[]=blog&modules_local[]=gallery&modules_local[]=fancybox&modules_local[]=tinymce&modules_local[]=cropper&modules_local[]=msv-core&modules_local[]=msv-api&modules_local[]=msv-seo&modules_local[]=msv-users&modules_local[]=search&modules_local[]=sitograph&modules_local[]=google-analytics&modules_local[]=theme-default&admin_login=admin&admin_password=$ADMIN_PASS&admin_create=1"
cat result.html

# done!
echo "Environment Install Successful."
echo "----------------------------------"
echo "Mysql Root password: $MASTER_PASS"
echo "Mysql user: sitograph"
echo "Mysql user password: $DB_PASS"

echo "Sitograph Install Successful."
echo "----------------------------------"
echo "Administrator login: admin"
echo "Administrator password: $ADMIN_PASS"
