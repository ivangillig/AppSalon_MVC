<?php 

require __DIR__ . '/../vendor/autoload.php';

use \Dotenv as Dotenv;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->safeLoad();


require 'funciones.php';
require 'database.php';


// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);