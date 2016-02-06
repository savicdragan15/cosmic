<?php

function aload_model($className){
    if(file_exists("model/".$className.".php")){
    require_once "model/".$className.".php";
    }
}

spl_autoload_register("aload_model");
