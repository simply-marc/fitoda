create or replace table products
(
    id int not null,
    category varchar(255) null,
    sku varchar(32) null,
    name varchar(255) null,
    description text null,
    shortdesc text null,
    price decimal(10,2) null,
    link text null,
    image text null,
    brand text null,
    rating tinyint null,
    caffeine_type enum('Caffeinated', 'Caffeine Free', 'Decaffeinated', 'Mixed', '') null,
    count smallint null,
    flavored tinyint(1) null,
    seasonal tinyint(1) null,
    instock tinyint(1) null,
    facebook tinyint(1) null,
    iskcup tinyint(1) null,
    constraint products_id_uindex
        unique (id)
);