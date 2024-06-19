# Web-development-1-PHP-application
This repository contains the result and product developed for the web-development 1 course assignment (for Inholland University of Applied Sciences) made by Sander Nederstigt.

This assignment involved the individual development of a PHP web application, in this case the CMS (or Content Management System for short) part of a simple bingo website entitled: 'Schaatsbingo.nl'.

This application utilizes the MVC design pattern principle with two different sets of controllers; with one set utilizing the views for the CMS pages of this application and another set exposing API controller request endpoints used by the second front-end Nuxt.js application developed for the Schaatsbingo website itself.

This PHP application covers the back-end for the majority of functionality and actions performed by this second front-end application (developed for the follow-up web-development 2 course which can be found within another github repository).

This repository contains a docker configuration with:
* NGINX webserver
* PHP FastCGI Process Manager with PDO MySQL support
* MariaDB (GPL MySQL fork)
* PHPMyAdmin

## Installation

1. Install Docker Desktop on Windows or Mac, or Docker Engine on Linux.
1. Clone the project

## Usage

In a terminal, run:
```bash
docker-compose up
```

NGINX will now serve files in the app/public folder. Visit localhost in your browser to check.
PHPMyAdmin is accessible on localhost:8080

If you want to stop the containers, press Ctrl+C. 
Or run:
```bash
docker-compose down
```