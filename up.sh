#!/bin/bash
git pull
git submodule update --init --recursive
chmod -R 777 data/cache
composer update

firstfile=true
for filename in `find ./config/ ./module/ -name *local.php.dist -o -name *local-development.php.dist -o -name development.config.php.dist `
do
    newfile=${filename:0:${#filename}-5}

    if [ ! -f "$newfile" ]; then
        if [ $firstfile = true ]; then
            echo " > Press [Enter] key to start searching end editing config files, OR [ANY KEY] to do it later manually:"
            firstfile=false

            read -s -n1  key
            if [ "$key" = $'\e' ]; then
                break
            fi
        fi
        echo "    > Config in $filename will installed.  Press [Enter] key to edit it or [ANY KEY] to skip:"
        read -s -n1  key
        if [ "$key" = $'\e' ]; then
            continue
        fi

        cp "$filename" "$newfile"
        vi "$newfile";
        echo "        > Saved in $newfile."
    fi
done

echo ' > Zf2Boilerplate up-to-date!'