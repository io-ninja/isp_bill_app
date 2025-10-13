# ==========================================================
# 🐘 Base image: PHP-FPM 8.3 + Nginx + CI4 Ready
# ==========================================================
FROM php:8.3-fpm

# Maintainer
LABEL maintainer="ascaliko.dev <ascaliko7@gmail.com>"

# ==========================================================
# 🔧 Install system dependencies & PHP extensions
# ==========================================================
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    openssh-server \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype-dev \
    libonig-dev \
    zip unzip git curl vim nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl pdo pdo_mysql mysqli mbstring zip gd \
    && docker-php-ext-enable intl mysqli pdo_mysql


# ==========================================================
# 🔐 Setup SSH (opsional)
# ==========================================================
RUN mkdir -p /var/run/sshd
RUN echo 'root:root' | chpasswd

# ==========================================================
# ⚙️ Setup folder structure & permissions
# ==========================================================
RUN mkdir -p /run/php /usr/share/nginx/html /var/log/supervisor
WORKDIR /usr/share/nginx/html
COPY . /usr/share/nginx/html
RUN chown -R www-data:www-data /usr/share/nginx/html

# ==========================================================
# 🧩 Copy Nginx config
# ==========================================================
COPY deploy/default.conf /etc/nginx/sites-enabled/default

# ==========================================================
# 🚀 Copy start script
# ==========================================================
COPY deploy/start.sh /start.sh
RUN chmod +x /start.sh

# ==========================================================
# ⚙️ Supervisor config to run multiple services
# ==========================================================
RUN echo "[supervisord]" > /etc/supervisor/conf.d/supervisord.conf && \
    echo "nodaemon=true" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "[program:php-fpm]" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "command=/usr/local/sbin/php-fpm -F" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "[program:nginx]" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "command=nginx -g 'daemon off;'" >> /etc/supervisor/conf.d/supervisord.conf

# ==========================================================
# 🌐 Expose HTTP port
# ==========================================================
EXPOSE 80

# ==========================================================
# 🏁 Start container
# ==========================================================
CMD ["/start.sh"]