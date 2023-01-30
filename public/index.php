<?php

require_once __DIR__ . '/../config/ini.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/routes.php';

use Core\Router\Router;
use Core\Database\DB;

//DB::connect('../config/database.php');

Router::route();
