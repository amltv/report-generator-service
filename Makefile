install:
	cp src/.env.example src/.env
	docker volume create composer_cache
	docker-compose run --rm composer install
	docker-compose run --rm artisan key:generate --ansi
	docker-compose run --rm artisan migrate
	docker-compose run --rm artisan db:seed
	docker-compose run --rm artisan storage:link
	docker-compose run --rm npm install
	docker-compose run --rm npm run build

update:
	docker-compose run --rm composer install
	docker-compose run --rm artisan migrate
	docker-compose run --rm npm run build

test:
	docker-compose run --rm artisan test

run:
	docker-compose up -d server
