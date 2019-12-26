<p align="center">
<img src="https://github.com/maxsv0/sitograph/blob/master/src/content/images/sitograph/sitograph-logo-dark-en.png" width="265">
</p>

## Table of Contents

- [About Sitograph](#about-sitograph)
  - [Example websites running under Sitograph CMS](#example-websites-running-under-sitograph-cms)
  - [Content Management System features overview](#content-management-system-features-overview)
  - [Admin UI homepage](#admin-ui-homepage)
- [Install Sitograph CMS](#install-sitograph-cms)
  - [1. Download Sitograph CMS](#1-download-sitograph-cms)
  - [2. Copy files and enable Apache configuration](#2-copy-files-and-enable-apache-configuration)
  - [3. Run Sitograph Installation wizard](#3-run-sitograph-installation-wizard)
- [Extending Sitograph modules](#extending-sitograph-modules)
  - [Default modules package of CMS](#default-modules-package-of-cms)
  - [Modules Repository](#modules-repository)
  - [Module deployment Workflow](#module-deployment-workflow)
- [Content Delivery](#content-delivery)
- [Bugs Reporting Workflow](#bugs-reporting-workflow)
- [Install Dependencies](#install-dependencies)
- [Install Sitograph Server Environment](#install-sitograph-server-environment)

# About Sitograph
Sitograph is open source Content Management System (CMS) that enables you to build websites and efficient online applications.

## Example websites running under Sitograph CMS
- http://ung.in.ua/
- http://infrastructure.kiev.ua/en/
- https://cloud-10.bitp.kiev.ua/en/
- https://cluster.bitp.kiev.ua/
- http://www.atlastour.ua/en/
- https://kicapastry.com/en/
- https://azura.ua/en/
- http://favorite-fishing.com/en/
- https://mcg.net.ua/
- http://advocate-didenko.com/
- http://atlastravel.az/
- http://coca-cola-csr-report.com.ua/
- http://yuvelirika.ua/
- https://arsis-ua.com/

## Content Management System features overview
We believe website development must be easy and enjoyable. 
Sitograph attempts to take care of common tasks used in the majority of web projects, such as: 
- Website structure and routing with multi-language support
- Manage content of a website: documents, photos, videos, etc.
- Adaptive web design optimized for [any type of mobile devices](#content-delivery)
- User management, sessions, [real-time analytics](#admin-ui-homepage)
- Email Marketing and customizable mailing templates
- [Configurable JSON API](https://www.sitograph.com/sitograph/API/)
- Internal PHP API for developers, [easy functionality extending](https://www.sitograph.com/sitograph/modules/)
- Scheduled job processing
- Updates via modules repository - [rep.msvhost.com](http://rep.msvhost.com/)
- Support and [active development](#module-deployment-workflow).

## Admin UI homepage
![Sitograph admin homepage](https://github.com/maxsv0/sitograph/blob/master/docs/screen-demo-sitograph.jpg)

# Install Sitograph CMS

### 1. Download Sitograph CMS
Download the latest version of Sitograph CMS and unzip the archive

```bash
wget https://github.com/maxsv0/sitograph/archive/v1.1.zip -O sitograph-v1.1.zip
unzip sitograph-v1.1.zip
cd sitograph-1.1
```

### 2. Copy files and enable Apache configuration

Run Install script to copy Sitograph files to the web root directory (default: /var/www/html).
This will also enable Apache configuration file (sitograph.conf) and enable required modules
```bash
chmod +x scripts/install.sh
sudo ./scripts/install.sh /var/www/html
```

### 3. Run Sitograph Installation wizard
![Sitograph Installation wizard](https://github.com/maxsv0/sitograph/blob/master/src/content/images/gallery/gallery3_photo1.jpg)


# Extending Sitograph modules
Sitograph CMS is a set of modules that can be easily configured from admin UI. 


# Default modules package of CMS
Default modules package is listed below.

```
include/
│   ....
└── module/
    ├── blog
    ├── gallery
    ├── cropper
    ├── fancybox
    ├── feedback
    ├── google-analytics
    ├── google-login
    ├── install
    ├── msv-api
    ├── msv-core
    ├── msv-seo
    ├── msv-users
    ├── search
    ├── sitograph
    ├── theme-default
    └── tinymce
```

## Modules Repository
List of available modules and extensions for Sitograph CMS can be found in [Repository catalog](http://rep.msvhost.com/).
![MSV Repository for Sitograph](https://raw.githubusercontent.com/maxsv0/repository/master/docs/screencapture-rep-msvhost-com.jpg)
http://rep.msvhost.com/


## Module deployment Workflow
![Sitograph Module Deployment Workflow](https://raw.githubusercontent.com/maxsv0/sitograph/development/docs/deployment-workflow.jpg)


# Content Delivery
Sitograph optimizes pages structure and together with ModPagespeed, it results in 100/100 score [Google Pagespeed Insights](https://developers.google.com/speed/pagespeed/insights/).

![Sitograph Pagespeed Insights](https://raw.githubusercontent.com/maxsv0/sitograph/development/docs/pagespeed-insights.jpg)


# Bugs Reporting Workflow
![Sitograph Bugs Reporting Workflow](https://raw.githubusercontent.com/maxsv0/sitograph/development/docs/issues-workflow.jpg)

To report a bug please visit [Github Issues page](https://github.com/maxsv0/sitograph/issues).

# Install Dependencies

Sitograph runs under LAMP stack. [ModPagespeed](https://developers.google.com/speed/pagespeed/module/) is used to optimize content delivery.

### Create new MySQL database
```bash
chmod +x scripts/mysqlcreate.sh
./scripts/mysqlcreate.sh root [your-mysql-root-password] sitograph
```
mysqlcreate.sh will create new database and user and grant all permissions for this DB
* First two arguments are username and password to connect to MySQL
* The third argument is a name of database to create
* The fourth argument is a password for a user. Leave blank to generate new password


### Install dependencies for PHP7
```bash
sudo apt-get update
sudo apt-get -y install php7.0-xml php7.0-gd php7.0-mbstring php7.0-zip php-curl
```

### To Install dependencies for PHP5
```bash
sudo apt-get update
sudo apt-get -y install php5-gd php5-curl
```

### To Install PageSpeed Module x64
```bash
wget https://dl-ssl.google.com/dl/linux/direct/mod-pagespeed-stable_current_amd64.deb
sudo dpkg -i mod-pagespeed-*.deb 
sudo service apache2 restart
```

### Install PageSpeed Module x32
```bash
wget https://dl-ssl.google.com/dl/linux/direct/mod-pagespeed-stable_current_i386.deb
sudo dpkg -i mod-pagespeed-*.deb 
sudo service apache2 restart
```

### VirtualBox symlink
VirtualBox symlink beetween local Sitograph folder and /var/www/html of virtual machine

```bash
sudo ln -s /media/sf_sitograph/src /var/www/html
sudo usermod -G vboxsf -a www-data
```
In VirtualBoxManager:
Settings -> Shared Folders -> Add. Folder name: sitograph


# Install Sitograph Server Environment

## Configure new instance running Ubuntu/CentOS/.. to setup Sitograph CMS
```bash
wget -O - https://raw.githubusercontent.com/maxsv0/sitograph/master/scripts/install-server.sh | bash
```

Example output:
```bash
Sitograph CMS Environment
--------------------------------------------
Mysql Root password: dooSho7wea4d
Mysql Sitograph user: sitograph
Mysql Sitograph user password: Mo0ohchaiquu
--------------------------------------------
Install Successful.
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
