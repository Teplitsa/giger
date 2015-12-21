#!/usr/bin/env bash

# go to folder
cd /var/www/public/

# db
echo 'CREATE DATABASE IF NOT EXISTS giger' | mysql --user=root --password=root
unzip -p ./attachments/startertest.sql.zip | mysql --user=root --password=root giger

# config
cat wp-config-orig.php | sed 's/dev_db/giger/g;s/dev_user/root/g;s/dev_password/root/g' > wp-config.php

# composer
composer install

# uploads
unzip ./attachments/uploads.zip -d ./wp-content/

# create .htaccess
cat ./attachments/.htaccess.orig > .htaccess
chmod -v 666 .htaccess