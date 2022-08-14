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
EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
rm composer-setup.php

# Dump autoloader
echo -e "\n${COLOR_CYAN}* UPDATE THE AUTOLOADER${COLOR_NC}"
php composer.phar dump-autoload

# Copy config to local and run editor
echo -e "\n\n${COLOR_CYAN}* COPY CONFIG TO EDIT IT${COLOR_NC}"
cp config/config.php config/config-local.php
if ! mcedit config/config-local.php; then
  nano config/config-local.php
fi

# Finish
echo -e "\n${COLOR_GREEN}* INSTALLATION COMPLETE${COLOR_NC}\n"
