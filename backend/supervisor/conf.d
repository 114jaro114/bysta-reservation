[supervisord]
nodaemon=true

[program:websockets]
command=/usr/bin/php /var/www/html/artisan websockets:serve
numprocs=1
autostart=true
autorestart=true
user=www-data
