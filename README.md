# LARAVEL / SPA / LIKE DTF.RU

![This is an image](https://i.imgur.com/awuEpIX.png)

## Installation

## Clone the source code
```bash
$ git clone https://github.com/ADamCarraway/DTF-clone.git
```
## Set the basic config
```bash
$ cp .env.example .env
```
> Edit the .env file and set the database and other config for the system after you copy the .env.example file.

## Set up the database:
```bash
$ php artisan migrate --seed
```

## Compile the js code:
```bash
$ npm run watch
```

## Run serve:
```bash
$ php artisan serve

$ php artisan websockets:serve
```
