#!/bin/bash

sudo apt install python3 -y
sudo apt install python3-pip -y
sudo apt install python3-venvmkdir ../scripts
cd /scripts
mkdir /python
mkdir /update
cd /python
python3 -m venv .venv/read
.venv/read/bin/pip3 install pyserial
.venv/read/bin/pip3 install mysql-connector-python
.venv/read/bin/pip3 install