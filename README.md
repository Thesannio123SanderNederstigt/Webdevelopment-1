# Web-development-PHP-application
This repository contains the culmination of work conducted for the web-development 1 course assignment.

This assignment involved the individual development of a PHP web application, with this app covering the back-end and majority of functionality utilized by the front-end Nuxt.js application developed for the follow up web-development 2 course.

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