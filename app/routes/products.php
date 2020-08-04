<?php

use Steampixel\Route;
use App\Controller\Products;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Route::add('/products', function() {
    (new Products(new Request(), new Response()))->index();
}, 'get');

Route::add('/products/list', function() {
    (new Products(new Request(), new Response()))->list();
}, 'get');

Route::add('/products/new', function() {
    (new Products(new Request(), new Response()))->new();
}, 'get');

Route::add('/products/add', function() {
    (new Products(new Request(), new Response()))->add();
}, 'post');

Route::add('/products/edit/([0-9\-]+)', function($sku) {
    (new Products(new Request(), new Response()))->edit($sku);
}, 'get');

Route::add('/products/edit', function() {
    (new Products(new Request(), new Response()))->update();
}, 'post');

Route::add('/products/delete/([0-9\-]+)', function($sku) {
    (new Products(new Request(), new Response()))->delete($sku);
}, 'get');