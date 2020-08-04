<?php

require __DIR__ . '/../vendor/autoload.php';

use Steampixel\Route;

require '../app/routes/dashboard.php';

require '../app/routes/products.php';

require '../app/routes/categories.php';

require '../app/routes/404.php';

Route::run('/');