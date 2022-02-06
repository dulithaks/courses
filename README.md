## 1. Clone and build repository

Clone this repository:
- `git clone https://github.com/dulithaks/courses.git`

Change directory into the project.
- `cd courses`

Copy environment file
- `cp .env.example .env`

Build docker
- `docker-compose build --no-cache`

Run docker
- `docker-compose up -d`

List containers
- `docker ps`

Log in to "app" containers
- `docker exec -it [container id] bash`

---------

## 2. Install composer packages and migrate database

*Please execute the below commands, once log in to the app container.*

Install packages
- `composer install`

Generate key
- `php artisan key:generate`

Cache settings
- `php artisan config:cache`

Migrate database
- `php artisan migrate`

Seed database
- `php artisan db:seed`


----

## 3. How to access the web app.

- Go to the web page with the URL http://127.0.0.1/

- Select a user from the dropdown
- Select a course from the dropdown
- Then submit the form.

They should show a success alert if everything goes right.
If there is any failure, it will display an error message.

----

## 4. How to run test

Login to the app container and then execute.

`php artisan config:clear && php artisan test --env=testing`

----

## 5. TODO

- Implement user login and protect routes.

- Implement soft delete.

- Add validation and DB constraints to avoid duplicate rows in the results table.

- Implement pagination fot user and course list rouets.

- Optimize docker container packages.
