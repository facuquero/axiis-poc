FROM php:8.1-cli

# Instalar dependencias
RUN apt-get update && apt-get install -y unzip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de la aplicación
COPY . .

# Instalar dependencias de Symfony
RUN composer install

# Exponer el puerto
EXPOSE 8000

# Comando para iniciar symfony serve
CMD ["symfony", "serve", "--no-tls", "--port=8000", "--allow-http"]