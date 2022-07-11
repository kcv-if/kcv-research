# KCV Research
KCV Research is a website to ~~flex~~ showcase publications and datasets made by ITS academics in the field of Intelligent Computing and Vision.

## Requirements

* [Install WSL](https://docs.microsoft.com/en-us/windows/wsl/install)
* [Install PHP 8](https://github.com/dptsi/laravel-docker-tutorial/tree/main/Instalasi%20PHP%208)
* [Install Composer](https://github.com/dptsi/laravel-docker-tutorial/tree/main/Instalasi%20Composer)
* Install PHP extensions needed by Composer
```
sudo apt install php8.1-zip php8.1-bcmath php8.1-curl \
php8.1-mbstring php8.1-xml unzip
```

## Setup
* Clone this repository
* Copy `.env.example` to `.env` in `src`
```
cp .env.example .env
```
* Install dependencies in `src`
```
composer install
```
* Build images
```
docker-compose build
```
* Run containers
```
docker-compose up -d
```
* Go into `kcv-research-php` inside `kcv-research` by using `docker exec -u 0 -it kcv-research-php sh` or the Docker Desktop user interface and run these commands
```
chown -R www-data:www-data storage
php artisan key:generate
```
* Open the website on `http://localhost:8088/`
* Execute the command `php artisan migrate:fresh --seed` to fresh migrate and seed the database
