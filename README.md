# LARAVEL / SPA / LIKE DTF.RU

![This is an image](https://i.imgur.com/awuEpIX.png)

## Installation
>The project is under development and refactoring. You will not be able to upgrade to the next version. Complete reinstallation only.

## Clone the source code
```bash
git clone https://github.com/ADamCarraway/DTF-clone.git
```
## Set the config
```bash
cp .env.example .env
```
> Edit the .env file and set the database and other config for the system after you copy the .env.example file.

## Install all packages:
```bash
composer install
```

## Generate config:
```bash
php artisan key:generate
```

## Set up the database:
```bash
php artisan migrate --seed
```

## Compile the js code:
```bash
npm run watch
```

## Run serve:
```bash
php artisan serve

php artisan websockets:serve

php artisan horizon
```
