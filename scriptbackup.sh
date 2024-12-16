#!/bin/bash
while ! mysql -u ${WORDPRESS_DB_USER} -p${WORDPRESS_DB_PASSWORD} -h ${WORDPRESS_DB_HOST} -e ";" ; do
	sleep 1
done

mysqldump -u $WORDPRESS_DB_USER --password=$WORDPRESS_DB_PASSWORD -h $WORDPRESS_DB_HOST $WORDPRESS_DB_NAME  > DBcopy.sql
