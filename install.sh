#!/bin/bash
#git submodule update --init --recursive
#chmod -R 777 data/cache
#composer update
read -p "Press [Enter] key to start edit config files..."


for filename in `find ./config/ ./module/ -name *.php.dist`
do
    newfile=${filename:0:${#filename}-5}
    echo " > Copied $filename to $newfile"
    vim "$newfile";
done

echo 'Zf2Boilerplate installed!'