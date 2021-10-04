install:
	composer install
	touch .env.local
	touch lastUpdateId.txt

run-server:
	php -S localhost:8081 -t public/