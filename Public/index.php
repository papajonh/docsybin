<?php
declare(strict_types=1);

// Autoload do Composer (PSR‑4)
 
//require_once '../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Router_Controllers\RouterController; 

// Instancia o controller que decide o que fazer
$app = new RouterController();
$app->dispatch();