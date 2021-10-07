#!/bin/bash

# create document root, fix permissions for www-data user and change owner to www-data
mkdir -p $APP_HOME/public
mkdir -p /home/$USERNAME && chown $USERNAME:$USERNAME /home/$USERNAME
usermod -u $UID $USERNAME -d /home/$USERNAME
groupmod -g $GID $USERNAME
chown -R ${USERNAME}:${USERNAME} $APP_HOME
