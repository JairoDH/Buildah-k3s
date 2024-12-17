#!/bin/bash

# Configuraciones de la base de datos
WORDPRESS_DB_USER="wpuser"
WORDPRESS_DB_PASSWORD="wp1994"
WORDPRESS_DB_NAME="wordpress"

# Obtener el host de MySQL desde Kubernetes
MYSQL_DB_HOST=$(kubectl get svc mysql -o jsonpath='{.spec.clusterIP}')

# Realizar el volcado de la base de datos
mysqldump --no-column-statistics -u $WORDPRESS_DB_USER -p$WORDPRESS_DB_PASSWORD -h $MYSQL_DB_HOST $WORDPRESS_DB_NAME > /home/jairo/databd.sql

# Verificar si el volcado fue exitoso
if [ $? -eq 0 ]; then
    echo "Respaldo de la base de datos completado con éxito."
else
    echo "Error en el respaldo de la base de datos."
    exit 1
fi

