# Install Sitograph CMS

### Download the latest version of Sitograph CMS and unzip archive
```
wget https://github.com/maxsv0/sitograph/archive/v1.0.zip -O sitograph-v1.0.zip
unzip sitograph-v1.0.zip
```

### Open Sitograph folder
```
cd sitograph-1.0
```

### Copy Sitograph files using Install script
```
chmod +x scripts/install.sh
sudo ./scripts/install.sh /var/www/html
```

### Enable Sitograph Apache configuration file and required modules
```
sudo cp scripts/sitograph.conf  /etc/apache2/conf-available/
sudo a2enconf sitograph
sudo a2enmod rewrite headers expires deflate
sudo service apache2 restart
```

## Sitograph Dependencies

Sitograph is designed to use MySQL database and run on Apache Web Server

### To Create MySQL database run
```
chmod +x scripts/mysqlcreate.sh
./scripts/mysqlcreate.sh root [your-mysql-root-password] sitograph
```
mysqlcreate.sh will create new database and user and grant all permissions for this DB
* First two arguments are username and password to connect to MySQL
* The third argument is a name of database to create
* The fourth argument is a password for a user. Leave blank to generate new password

### To Install dependencies for PHP7
```
sudo apt-get update
sudo apt-get -y install php7.0-xml php7.0-gd php7.0-mbstring php-curl
```

### To Install dependencies for PHP5
```
sudo apt-get update
sudo apt-get -y install php5-gd php5-curl
```

# Configure server and install Sitograph CMS

## To Install Sitograph CMS with all dependencies run
```
wget -O "install-server.sh" "https://raw.githubusercontent.com/maxsv0/sitograph/master/scripts/install-server.sh"
chmod +x install-server.sh
sudo ./install-server.sh>install.log 2>&1
tail -n 10 install.log
```
Install Script writes log to `install.log` file.
Generated passwords will be displayed at the end of a process.

Server installation script steps:
* install tools (unzip wget pwgen debconf-utils)
* install LAMP server
* install PHP7 or PHP5 dependencies (depending on installed version of PHP)
* download Sitograph CMS v1.0 release archive from GitHub
* install Sitograph to /var/www/html
* enable Sitograph Apache configuration file
* (optional) run CMS installation wizard with common setup - Note! This is disabled by default. Uncomment lines in install-server.sh to enable this step
* output generated passwords