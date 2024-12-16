ç#Selección de imagen
FROM debian:12

# Actualizar e instalar las dependencias
RUN apt-get update && apt-get install -y \
    apache2 \
    mariadb-client \
    php \
    php-mysql \
    git \
    && rm -rf /var/lib/apt/lists/*

# Descargar WordPress
RUN git clone https://github.com/JairoDH/Keptn-k3s.git /tmp/repo && \
    cp -r /tmp/repo/wordpress/* /var/www/html/ && \
    rm -rf /tmp/repo && \
    rm -rf /var/www/html/index.html
 
# Variables de entorno para la base de datos
ENV WORDPRESS_DB_USER=${bd_user}
ENV WORDPRESS_DB_PASSWORD=${bd_psswd} 
ENV WORDPRESS_DB_NAME=${bd_name}
ENV WORDPRESS_DB_HOST= mysql

# Configurar los permisos
RUN chown -R www-data:www-data /var/www/html

COPY scriptbackup.sh /usr/local/
RUN chmod +x /usr/local/scriptbackup.sh

COPY DBcopy.sql /var/lib/mysql/
 
# Exponer los puertos
EXPOSE 80 443

# Comando de inicio
CMD ["apache2ctl", "-D", "FOREGROUND"]
