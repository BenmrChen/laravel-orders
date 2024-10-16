#!/bin/bash

# 設置存儲目錄的權限
chmod -R 777 /var/www/storage

# 運行傳入的命令（例如 "php artisan swoole:http start"）
exec "$@"
