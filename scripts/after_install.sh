#!/bin/bash

set -eux

cd ~/finder-space
php artisan migrate --force
php artisan config:cache
