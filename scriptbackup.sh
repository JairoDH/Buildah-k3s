#!/bin/bash

WORDPRESS_DB_USER="wpuser"
WORDPRESS_DB_PASSWORD="wp1994"
WORDPRESS_DB_NAME="wordpress"
MYSQL_DB_HOST=10.43.74.12
#MYSQL_DB_HOST=$(kubectl get svc mysql -o jsonpath='{.spec.clusterIP}')

# Realizar el volcado de la base de datos sin la opción '--no-column-statistics'
mysqldump --set-gtid-purged=OFF --no-tablespaces -u $WORDPRESS_DB_USER -p"$WORDPRESS_DB_PASSWORD" -h $MYSQL_DB_HOST $WORDPRESS_DB_NAME > /home/jairo/databd.sql

# Verificar si el volcado fue exitoso
if [ $? -eq 0 ]; then
    echo "Respaldo de la base de datos completado con éxito."
else
    echo "Error en el respaldo de la base de datos."
    exit 1
fi

