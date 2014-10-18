#!/bin/bash
git pull
git submodule update --init --recursive
chmod -R 777 data/cache
composer update

firstfile=true
for filename in `find ./config/ ./module/ -name *local.php.dist`
do
    newfile=${filename:0:${#filename}-5}

    if [ ! -f "$newfile" ]; then
        if [ $firstfile = true ]; then
            read -p " > Press [Enter] key to start searching end editing config files, OR [Ctrl+C] for do it later manually:"
            firstfile=false
        fi
        read -p "    > Config in $filename now installed in $newfile. Press [Enter] key to edit it:"

        cp "$filename" "$newfile"
        vi "$newfile";
    fi
done

echo ' > Zf2Boilerplate up-to-date!'