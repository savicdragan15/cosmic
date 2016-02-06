<?php
include 'config.php';
require_once 'ControllerLoader.php';
require_once 'controller/Controller.php';

$controller = isset($_GET['controller'])?$_GET['controller']:'Home';
$method = isset($_GET['method'])?$_GET['method']:'index';

$controller = $controller."Controller";
$path_to_controller = realpath("controller/".$controller.".php");

if(file_exists($path_to_controller)){
    include $path_to_controller;
    ControllerLoader::loadController($controller, $method);
}else{
    echo "Error";
}
