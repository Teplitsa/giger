#!/usr/bin/env bash

#vars
sitename=${1:-giger}

if [ -d "/var/www/$sitename" ]; then
    echo "$sitename already exists"
    exit 1
fi


# copy code into site dir
cp -R /var/www/giger.egg  /var/www/${sitename} 

# go to folder
cd /var/www/${sitename}/

# db
echo "CREATE DATABASE IF NOT EXISTS $sitename" | mysql --user=root --password=root
unzip -p ./attachments/startertest.sql.zip | mysql --user=root --password=root ${sitename}

# config
cat wp-config-orig.php | sed "s/dev_db/$sitename/g;s/dev_user/root/g;s/dev_password/root/g;s/giger\.local/$sitename\.local/g" > wp-config.php

# composer deps
composer install

# uploads
unzip ./attachments/uploads.zip -d ./wp-content/

# create .htaccess
cat ./attachments/.htaccess.orig > .htaccess
chmod -v 666 .htaccess

#replace domain
if [ $sitename != giger ]
then
	php wp-content/vendor/interconnectit/search-replace-db/srdb.cli.php -v=true -h localhost -u root --name ${sitename} -p root -s giger.local -r ${sitename}.local
fi

