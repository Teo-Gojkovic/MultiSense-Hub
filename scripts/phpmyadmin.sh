#! /bin/bash

sudo apt install mariadb-server mariadb-client -y
sudo apt install phpmyadmin apache2 php-zip php-gd php-json php-curl libapache2-mod-php -y
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo a2enconf phpmyadmin.conf
sudo systemctl reload apache2.service