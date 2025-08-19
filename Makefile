up:
	docker compose up -d
down:
	docker compose down
build:
	docker compose up -d --build
psalm:
	./vendor/bin/psalm
psalm-init:
	./vendor/bin/psalm --init
psalm-clear:
	./vendor/bin/psalm --no-cache

phpstan:
	vendor/bin/phpstan analyse src
codesniffer:
	vendor/bin/phpcs src
codesniffer-style:
	vendor/bin/phpcbf --standard=PSR12 src
