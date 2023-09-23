deploy:
	rsyn -avz public/build missionmanager:~/sites/jobmanagr.com/jobmanagr-api/public
	ssh missionmanager 'cd sites/jobmanagr.com/jobmanagr-api && git pull origin main && make install'

install: vendor/autoload.php .env public/storage
	php artisan cache:clear
	php artisan migrate

public/storage:
	php artisan storage:link

vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php

public/build/manifest.json: packgage.json
	npm install
	npm run build