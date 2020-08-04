<?php

use Steampixel\Route;
use App\Controller\Dashboard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Route::add('/', function() {
    (new Dashboard(new Request(), new Response()))->index();
}, 'get');