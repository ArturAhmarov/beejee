<?php
session_start();
use Lib\Routing;

include 'template/header.php';
require 'vendor/autoload.php';

$route = new Routing();
$route->route();

include 'template/footer.php';

