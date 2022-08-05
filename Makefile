.PHONY: install helpers

all: install seed

install: docker-up
	docker-compose exec app rm -rf vendor composer.lock
	docker-compose exec app composer install
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan storage:link

helpers:
	php artisan ide-helper:generate
	php artisan ide-helper:models -M
	php artisan ide-helper:meta

analyse:
	./vendor/bin/pint
	./vendor/bin/phpstan analyse

insight:
	docker-compose exec app php artisan insight

docker-up:
	docker-compose build app
	docker-compose up -d

test:
	docker-compose exec app php artisan test

down:
	docker-compose down

app:
	docker-compose exec app /bin/bash

db:
	docker-compose exec db bash

seed:
	docker-compose exec app php artisan migrate:fresh --seed
