1. This is test task for drug_cart.
2. To start the project in terminal go to root foder where this readme file currently is and run "docker-compose up -d --build".
3. Host name and port can be found and changed in .env file. As long as it is a console command basically they are not needed. Righ now they set to HOSTNAME=drug_cart_test_task.com, MAIN_PORT=8081.
4. After "docker-compose up -d --build" successfully, run "docker exec -it <id of fpm container> bash". Id can be seen when run "docker ps".
5. When inside fpm container, run: "composer install". 
6. Then run "mkdir var/result" - this would be the folder where result is going to be stored. Not according to the task but still...
7. Then run "bin/console app:parse-page https://repka.ua/uk/products/smartfony/" or "app:parse-page https://rozetka.com.ua/notebooks/c80004/" and result will be seen in app/var/result folder.
8. Right now app can only process pages from two stores: rozetka.com.ua and repka.ua. 
9. If some problems with docker containers just run "docker system prune -a" to clean all the data from previouse builds.

Enjoy!






Initial Test task:
3 pages of any internet store must be parsed. Data must be saved in root project folder.

Data that needs to be saved:
- product title
- price
- image link
- product link

Requirements: 
- Task must be implemented as a console command.
- Html parsing should be done via XPath.
- Request can be done through any composer library.
- Exceptions should be processed.
- OOP
- To run the project composer install should be done and run the program
- Tests are not nessesary.
