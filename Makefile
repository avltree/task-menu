init:
ifeq (,$(wildcard ./.env))
	cp .env.example .env
endif
	docker-compose up -d
	docker-compose run php bash -c 'composer install'

up:
	docker-compose up -d
	docker-compose exec php bash -c 'php artisan serve --host=0.0.0.0'

test:
	docker-compose up -d
	docker-compose exec php bash -c 'vendor/bin/phpunit'

down:
	docker-compose down
