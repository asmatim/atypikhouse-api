# AtypikHouse API

## About
AtypikHouse is a web platform solution to find amazing destination to spend a good time, it allows you to book online. For owners, it is the best place to reach more clients.

## Description
This repository contains the backend code of AtypikHouse, it is built with Symfony API Platform. A frontend solution will be consuming this API to provide a rich user experience.

## Setup

### Install
1. Install VirtualBox
2. Install Vagrant
3. Install Composer
4. Clone this repository
5. cd to repo and "composer install"

### Configure
- Edit the file Homestead.yaml

    Set the path under the key folders>map to the path where you cloned this repo
    
        folders:
            -
                map: ~/projects/atypikhouse-api

In your hosts file add "**192.168.10.10 atypikhouse.local**"

## Run
> cd path/to/atypikhouse-api

> vagrant up

Now you can access the API platform web interface in your browser under
https://atypikhouse.local/api
