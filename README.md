## How start
```
git clone https://github.com/andrey900/naveksoft-test.git
cd naveksoft-test
composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan websockets:serve &
```
Open in browser [http://localhost](http://localhost) (laravel start page)

Open in websocket console [http://localhost/laravel-websockets](http://localhost/laravel-websockets)

## Api enpoints

``POST: /api/register`` - register new user, _user with **id 1** is an **administrator**_

``POST: /api/login`` - login user, get authorization token

### Usage authorization token (bearer authorization)
``GET: /api/reviews`` - get all paginated reviews

``POST: /api/reviews`` - add new review (fields: `review`)

``GET: /api/reviews/{id}`` - get review

``POST: /api/reviews/{id}`` - add new answer for review (only administrator) (fields: `review`)
