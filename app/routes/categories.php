<?php

use Steampixel\Route;
use App\Controller\Categories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Route::add('/categories', function() {
    (new Categories(new Request(), new Response()))->index();
}, 'get');

Route::add('/categories/list', function() {
    (new Categories(new Request(), new Response()))->list();
}, 'get');

Route::add('/categories/new', function() {
    (new Categories(new Request(), new Response()))->new();
}, 'get');

Route::add('/categories/add', function() {
    (new Categories(new Request(), new Response()))->add();
}, 'post');

Route::add('/categories/edit/([0-9\-]+)', function($codigo) {
    (new Categories(new Request(), new Response()))->edit($codigo);
}, 'get');

Route::add('/categories/edit', function() {
    (new Categories(new Request(), new Response()))->update();
}, 'post');

Route::add('/categories/delete/([0-9\-]+)', function($codigo) {
    (new Categories(new Request(), new Response()))->delete($codigo);
}, 'get');