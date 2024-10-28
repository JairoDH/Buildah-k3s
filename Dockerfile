#Selección de imagen
FROM debian:12

# Variables de entorno para la base de datos
ENV WORDPRESS_DB_USER=${bd_user}
ENV WORDPRESS_DB_PASSWORD=${bd_psswd}
ENV WORDPRESS_DB_NAME=${bd_name}
ENV WORDPRESS_DB_HOST=mysql-service

# Actualizar e instalar las dependencias
RUN apt-get update && apt-get install -y \
    apache2 \
    mariadb-client \
    php \
    php-mysql \
    curl \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Descargar WordPress
RUN curl -o wordpress.zip https://wordpress.org/latest.zip && \
    unzip wordpress.zip && \
    mv wordpress/* /var/www/html/ && \
    rm -rf wordpress wordpress.zip

# Configurar los permisos
RUN chown -R www-data:www-data /var/www/html

# Exponer los puertos
EXPOSE 80 443

# Comando de inicio
CMD ["apache2ctl", "-D", "FOREGROUND"]
