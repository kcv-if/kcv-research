# KCV Research
KCV Research is a website to ~~flex~~ showcase publications and datasets made by ITS academics in the field of Intelligent Computing and Vision.

## Database Design
https://dbdiagram.io/d/6307927af1a9b01b0fe35328

## Requirements

### Install WSL (Windows)
* [Install WSL](https://docs.microsoft.com/en-us/windows/wsl/install)

### Install PHP
* Remove installed PHP
```
sudo apt remove php*
```
* Add `ondrej/php` repository
```
sudo add-apt-repository ppa:ondrej/php && sudo apt update && sudo apt upgrade -y
```
* Install PHP 8.1
```
sudo apt install php8.1-fpm
```
* Check if PHP is installed by viewing the version
```
php -v
```

### Install Composer
* Remove installed Composer
```
sudo apt remove composer
```
* Install Composer by following the `Command-line installation` in https://getcomposer.org/download/
* Move `composer.phar` from current working directory to `PATH`
```
sudo mv composer.phar /usr/local/bin/composer
```
* Check if Composer is installed by viewing the version
```
composer -V
```
* Install PHP extensions needed by Composer
```
sudo apt install php8.1-zip php8.1-bcmath php8.1-curl php8.1-mbstring php8.1-xml unzip
```

## Setup
* Clone this repository in **WSL** for Windows
* Copy `.env.example` to `.env` in `src`
```
cp .env.example .env
```
* Install dependencies in `src`
```
composer install
```
* Run containers
```
docker-compose up -d
```
* Go into `kcv-research-php` inside `kcv-research` by using `docker exec -u 0 -it kcv-research-php sh` or the Docker Desktop user interface and run these commands
```
chown -R www-data:www-data storage && php artisan key:generate
```
* Open the website on `http://localhost:8088/`
* Execute the command `php artisan migrate:fresh --seed` to fresh migrate and seed the database
