### Tosifa Test case

## Installation:

```
composer install
```

set DB_DATABASE an absolute path for sqlite then run seeds

```
php artisan migrate
php artisan db:seed
```

## Running test:

```angular2html
php artisan test
```

we have 3 types user:

user1:

view_product_name
view_product_image
view_order_price
view_order_quantity

user2:

update_product_sell_price
view_product_name

user3:

all permissions

## For using api read request.http
