install:
	composer install
	touch .env.local

run-server:
	php -S localhost:8081 -t public/