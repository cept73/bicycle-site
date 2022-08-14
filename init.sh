#!/bin/bash

# Terminal text colors
COLOR_GREEN='\033[0;32m'
COLOR_CYAN='\033[0;36m'
COLOR_NC='\033[0m'

# Already exists
if [ -f "composer.phar" ]; then
    echo -e "\n${COLOR_GREEN}Installation is already done${COLOR_NC}\n"
    exit
fi

# Download composer.phar
echo -e "\n${COLOR_CYAN}* INSTALLING COMPOSER.PHAR${COLOR_NC}"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Dump autoloader
echo -e "\n${COLOR_CYAN}* UPDATE THE AUTOLOADER${COLOR_NC}"
php composer.phar dump-autoload

# Copy config to local and run editor
echo -e "\n\n${COLOR_CYAN}* COPY CONFIG AND EDIT IT${COLOR_NC}"
cp config/config.php config/config-local.php

if ! mcedit config/config-local.php; then
  nano config/config-local.php
fi

# Finish
echo -e "\n${COLOR_GREEN}* INSTALLATION COMPLETE${COLOR_NC}\n"
