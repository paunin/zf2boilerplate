#!/bin/bash
git submodule update --init --recursive

chmod -R 777 data/cache
composer update

read -p "Press [Enter] key to start edit config file..."
vim protected/config/custom.php

echo 'Zf2Boilerplate installed!'