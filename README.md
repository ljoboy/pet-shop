
# PET SHOP

This is a pet shop e-commerce Backend (API)


## Installation

### Docker

Build `docker image`

```sh
docker-compose build app
```
Then run

```sh
docker-compose up -d
```

To shut down all containers

```sh
docker-compose down
```

Optionally

To list running containers :
```sh
docker-compose ps
```
To access in terminal mode

```sh
docker-compose exec app /bin/bash
```
### Laravel Dependencies

Composer
```sh
docker-compose exec app rm -rf vendor composer.lock
docker-compose exec app composer install
```
Then
```sh
docker-compose exec app php artisan key:generate
```



## Demo

Now go to your browser and access your server’s domain name or IP address on port 8000
```
http://127.0.0.1:8000
```


## Running Tests

To run tests, run the following command

```sh
  docker-compose exec app php artisan test
```
