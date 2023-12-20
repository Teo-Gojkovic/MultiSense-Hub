#!/bin/bash

apt-get update -y
apt install apache2 -y
sudo ufw allow http