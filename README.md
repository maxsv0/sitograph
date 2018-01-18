<p align="center">
<img src="https://github.com/maxsv0/sitograph/blob/master/src/content/images/sitograph/sitograph-logo-dark-en.png" width="265"></p>
</p>


## About Sitograph
Sitograph is open source Content Management System (CMS) that enables you to build websites and efficient online applications.

## Sitograph CMS Features Overview
We believe website development must be easy and enjoyable. 
Sitograph attempts to take care of common tasks used in the majority of web projects, such as: 
- Website structure and routing
- Multi-language support
- Manage content of a website: documents, photos, videos, etc.
- User management, sessions, real-time analytics
- Email Marketing and customizable mailing templates
- Scheduled job processing
- Configurable JSON API
- Internal PHP API for developers
- Updates and functionality extending via modules repository

## Sitograph admin homepage
![Sitograph admin homepage](https://github.com/maxsv0/sitograph/blob/master/docs/screen-demo-sitograph.jpg)

# Install Sitograph CMS

### 1. Download the latest version of Sitograph CMS and unzip the archive
```bash
wget https://github.com/maxsv0/sitograph/archive/v1.0.zip -O sitograph-v1.0.zip
unzip sitograph-v1.0.zip
cd sitograph-1.0
```

### 2. Run Install script to copy Sitograph files to the web root directory (default: /var/www/html).
```bash
chmod +x scripts/install.sh
sudo ./scripts/install.sh /var/www/html
```

### 3. Enable Apache configuration file (sitograph.conf) and enable required modules
```bash
sudo cp scripts/sitograph.conf  /etc/apache2/conf-available/
sudo a2enconf sitograph
sudo a2enmod rewrite headers expires deflate pagespeed
sudo service apache2 restart
```
### 4. Run Sitograph Installation wizard
![Sitograph Installation wizard](https://github.com/maxsv0/sitograph/blob/master/src/content/images/gallery/gallery3_photo1.jpg)

# Extensions Repository for Sitograph
http://rep.msvhost.com/
![MSV Repository for Sitograph](https://raw.githubusercontent.com/maxsv0/repository/master/docs/screencapture-rep-msvhost-com.jpg)
Download modules for Sitograph and MSV Framework.


# Sitograph Deployment Workflow
![Sitograph Deployment Workflow](https://raw.githubusercontent.com/maxsv0/sitograph/development/docs/deployment-workflow.jpg)


# Bugs Reporting Workflow
![Sitograph Bugs Reporting Workflow](https://raw.githubusercontent.com/maxsv0/sitograph/development/docs/issues-workflow.jpg)



# Install Sitograph Dependencies

Sitograph runs under LAMP stack. [ModPagespeed](https://developers.google.com/speed/pagespeed/module/)  is used to optimize content delivery.

### Install dependencies for PHP7
```bash
sudo apt-get update
sudo apt-get -y install php7.0-xml php7.0-gd php7.0-mbstring php7.0-zip php-curl
```

### To Install PageSpeed Module x64
```bash
wget https://dl-ssl.google.com/dl/linux/direct/mod-pagespeed-stable_current_amd64.deb
sudo dpkg -i mod-pagespeed-*.deb 
sudo service apache2 restart
```

### Create new MySQL database
```bash
chmod +x scripts/mysqlcreate.sh
./scripts/mysqlcreate.sh root [your-mysql-root-password] sitograph
```
mysqlcreate.sh will create new database and user and grant all permissions for this DB
* First two arguments are username and password to connect to MySQL
* The third argument is a name of database to create
* The fourth argument is a password for a user. Leave blank to generate new password

### To Install dependencies for PHP5
```bash
sudo apt-get update
sudo apt-get -y install php5-gd php5-curl
```

### Install PageSpeed Module x32
```bash
wget https://dl-ssl.google.com/dl/linux/direct/mod-pagespeed-stable_current_i386.deb
sudo dpkg -i mod-pagespeed-*.deb 
sudo service apache2 restart
```

### VirtualBox symlink beetween local Sitograph folder and /var/www/html of virtual machine
```
sudo ln -s /media/sf_sitograph/src /var/www/html
sudo usermod -G vboxsf -a www-data
```
In VirtualBoxManager:
Settings -> Shared Folders -> Add. Folder name: sitograph


# Install Sitograph Server Environment

## Configure empty Ubuntu/CentOS/.. image to run Sitograph CMS
```bash
wget -O "install-server.sh" "https://raw.githubusercontent.com/maxsv0/sitograph/master/scripts/install-server.sh"
chmod +x install-server.sh
sudo ./install-server.sh
```

Example output:
```bash
Environment Install Successful
--------------------------------------------
Mysql Root password: dooSho7wea4d
Mysql Sitograph user: sitograph
Mysql Sitograph user password: Mo0ohchaiquu
--------------------------------------------
Sitograph Install Successfull
--------------------------------------------
Administrator login: admin
Administrator password: xoh7ooSu3wai
```

Don't forget to save passwords that will be displayed at the end of a process, otherwise, they will be lost.

Server installation script includes:
* install tools (unzip wget pwgen debconf-utils)
* install LAMP server
* install PHP7 or PHP5 dependencies (depending on installed version of PHP)
* download Sitograph CMS v1.0 release archive from GitHub
* install Sitograph to /var/www/html
* enable Sitograph Apache configuration file
* run CMS installation wizard with common setup
* output generated passwords
