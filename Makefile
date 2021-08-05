install:
	composer install
	touch .env.local

run-server:
	php -S localhost:8080 -t public/