## Introduction
A Laravel Restful API and VueJS project to guess the dish you are thinking. This systema learning new dishes with the use.

This system has theses features:
- To ask the characteristcs of the dish
- To learn with the use
- To count how many times a dish was played
- To store new dishes in Database with his new characteristic
- To count victories and defeats

## Installation
Steps to install Gourmet Game project in your machine:
- 1- Clone or download this repository
- 2- Run "composer install"
- 3- Create database "gourmet_game"
- 4- Create the ".env" file and set the database informations. You can duplicate the ".env.example" file, rename to ".env" and just add the database information
- 5- Run "php artisan migrate" to create the tables in database
- 5- Run "php artisan db:seed" to insert some rows in the tables
- 6- Start your server and access it!