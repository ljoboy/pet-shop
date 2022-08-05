
# PET SHOP

This is a pet shop e-commerce Backend (API)


## Installation

### Docker

```shell
make all
```

### Not Docker ?
```shell
rm -rf vendor composer.lock
```
```shell
composer install
```
```shell
php artisan key:generate
```
```shell
php artisan storage:link
```

and enjoy...

## Test and Analyse

```shell
make test
```
```shell
make insight
```
```shell
make analyse
```

### Interact with docker image
App App Image
```shell
make app
```
DB Image
```shell
make db
```
Seed data
```shell
make seed
```



## Demo

Now go to your browser and access your server’s domain name or IP address on port 8000
```http request
http://127.0.0.1:8000
```
or click [here](http://127.0.0.1:8000)

## API Docs
```http request
https://localhost:8080/api/docs
```
or click [here](http://127.0.0.1:8000/api/docs)


## Running Tests

To run tests, run the following command

```shell
  docker-compose exec app php artisan test
```
