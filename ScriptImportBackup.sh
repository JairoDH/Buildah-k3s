#!/bin/bash

# Configuración de credenciales y base de datos
WORDPRESS_DB_USER="wpuser"
WORDPRESS_DB_PASSWORD="wp1994"
WORDPRESS_DB_NAME="wordpress"
MYSQL_DB_HOST=$(kubectl get svc mysql -o jsonpath='{.spec.clusterIP}')

# Verificación de la IP del servicio MySQL
if [ -z "$MYSQL_DB_HOST" ]; then
  echo "Error: No se pudo obtener la IP del servicio MySQL."
  exit 1
fi
echo "IP del servicio MySQL: $MYSQL_DB_HOST"

# Reemplazo de las URLs en el archivo SQL
SQL_FILE="/home/jairo/databd.sql"

if [ ! -f "$SQL_FILE" ]; then
  echo "Error: El archivo $SQL_FILE no existe."
  exit 1
fi

echo "Reemplazando 'http://dev.touristmap.es' con 'https://www.touristmap.es' en el archivo SQL..."
sed -i 's|http://dev.touristmap.es|https://www.touristmap.es|g' "$SQL_FILE"

# Importar la base de datos
echo "Importando la base de datos..."
mysql -u "$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" -h "$MYSQL_DB_HOST" "$WORDPRESS_DB_NAME" < "$SQL_FILE"

# Comprobar si la importación fue exitosa
if [ $? -eq 0 ]; then
  echo "La base de datos se importó correctamente."
else
  echo "Error: Falló la importación de la base de datos."
  exit 1
fi
