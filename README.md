# technical-task

Welcome to my technical task: Crypto App!

To start the app, use:

'docker-compose up --build'
 
to build and run the container.

Afterwards, use the command:

'docker exec -it techincal-task-php-fpm-1 php bin/console doctrine:migrations:migrate'

in the terminal to apply the necessary database migrations.

Then, use:

'docker exec -it techincal-task-php-fpm-1 php bin/console fetch:crypto-data'

to fetch data from the API and populate the database.

Visit http://localhost:8080/ to access the web page where you can list cryptocurrencies, click on their symbols for detailed information, and filter them by minimum or maximum price.

