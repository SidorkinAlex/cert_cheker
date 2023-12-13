test:
	echo "Hello, World"
	cd cert_checker/; vendor/bin/phpstan analyse ./src/ main.php;
	cd cert_checker/;  ./vendor/bin/phpunit ./tests/git