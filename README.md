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

## Product list request

GET localhost:8000/api/products?user_id=1

## Update Product

POST localhost:8000/api/products/1
Content-Type: application/json

{
"name": "test name",
"image": "test image",
"sell_price": 1000,
"buy_price": 900,
"stock": 100,
"visits": 1000,
}
