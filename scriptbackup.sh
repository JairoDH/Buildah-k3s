#!/bin/bash

WORDPRESS_DB_USER="wpuser"
WORDPRESS_DB_PASSWORD="wp1994"
WORDPRESS_DB_NAME="wordpress"
#MYSQL_DB_HOST=10.43.74.12
MYSQL_DB_HOST=$(kubectl get svc mysql -o jsonpath='{.spec.clusterIP}')

mysqldump --set-gtid-purged=OFF --no-tablespaces -u $WORDPRESS_DB_USER -p$WORDPRESS_DB_PASSWORD -h $MYSQL_DB_HOST $WORDPRESS_DB_NAME > /home/jairo/databd.sql
