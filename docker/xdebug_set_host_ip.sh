#!/bin/bash

# Obtener la IP del host
HOST_IP=$(ip route | awk '/default/ { print $3 }')

# Ruta al archivo xdebug.ini
XDEBUG_INI="/usr/local/etc/php/conf.d/xdebug.ini"

# Sobrescribir siempre la línea xdebug.client_host con la IP actual
sed -i "s|^xdebug.client_host=.*|xdebug.client_host=$HOST_IP|" "$XDEBUG_INI"
echo "xdebug.client_host sobrescrito con $HOST_IP"