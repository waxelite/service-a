# Используем официальный образ PHP с FPM
FROM php:8.2-fpm

# Устанавливаем необходимые зависимости и библиотеки для работы с изображениями и базами данных
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Устанавливаем Composer для управления зависимостями
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем владельца для каталога, чтобы избежать проблем с правами доступа
RUN chown -R www-data:www-data /var/www/html
RUN git config --global --add safe.directory /var/www/html

# Копируем файлы проекта в контейнер
COPY . /var/www/html/

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Выполняем обновление зависимостей через Composer
RUN php /usr/local/bin/composer install --no-dev --optimize-autoloader

# Копируем файл .env, если он существует в проекте
# Вместо этого .env должен быть в корне проекта или предоставляться в процессе сборки
COPY .env.example .env

# Открываем порт 8001 для подключения
EXPOSE 8001

# Запуск PHP встроенного сервера на порту 8001 для этого сервиса
CMD ["php", "-S", "0.0.0.0:8001", "-t", "public"]
