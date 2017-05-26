# Install Sitograph CMS

### Install LAMP stack (if not installed yet)
```
sudo apt-get update
sudo apt-get install lamp-server^
```

### Install dependencies
```
sudo apt-get update
sudo apt-get install php7.0-xml php7.0-gd php7.0-mbstring
```

### Clone from GIT repository
```
git clone https://github.com/maxsv0/sitograph
```

### Copy Sitograph files
```
sudo cp -ar sitograph/src/.  /var/www/html
sudo chown -R www-data:www-data /var/www/html
sudo cp -ar sitograph/src/templates/default/.  /var/www/html/templates/custom/
```

### Enable Apache configuration and modules
```
sudo cp sitograph/sitograph.conf  /etc/apache2/conf-available/
sudo a2enconf sitograph
sudo a2enmod rewrite headers expires deflate
sudo service apache2 restart
```

### Create MySQL database (if needed)
```
chmod +x sitograph/mysqlcreate.sh
sitograph/mysqlcreate.sh root rootpassword sitograph
```
mysqlcreate.sh will create new database and user and grant all permissions for this DB
* First two arguments are username and password to connect to MySQL
* Third argument is a name of database to create
* Fouth argument is a password for a user. Leave blank to generate new password
