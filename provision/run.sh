#!/usr/bin/env bash

# updating
sudo apt-get update
sudo composer self-update

# SSL
sudo apt-get install openssl -y
sudo mkdir /etc/apache2/ssl
sudo openssl req -x509 -nodes -days 1095 -newkey rsa:2048 -subj "/C=RU/ST=Denial/L=Moscow/O=Test/CN=*.local" -keyout  /etc/apache2/ssl/apache.key -out /etc/apache2/ssl/apache.crt

sudo a2enmod ssl

# vistual hosts config
cp /var/www/provision/all.conf /etc/apache2/sites-available/all.conf
sudo a2enmod vhost_alias
sudo a2ensite all.conf
sudo a2dissite scotchbox.local.conf
sudo a2dissite 000-default.conf

# restart
sudo service apache2 restart

#create first site
source /var/www/provision/giger_add.sh