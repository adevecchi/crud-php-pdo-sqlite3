<?php

use Steampixel\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

Route::pathNotFound(function($path) {
    $response = new Response();

    $pageContent = file_get_contents('../templates/404.html');

    $response->setContent($pageContent);
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
    $response->send();
});

Route::methodNotAllowed(function($path, $method) {
    $response = new RedirectResponse('/404');
    $response->send();
});