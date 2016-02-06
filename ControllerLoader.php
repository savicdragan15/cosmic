<?php
/**
 * 
 */
class ControllerLoader{
     public static function loadController($cont,$method){
        $controller_object = new $cont();
        if (!is_subclass_of($controller_object, 'Controller')){
            echo 'no controller';
            exit;
        }
        if(method_exists($controller_object,$method)){
         call_user_func_array(array($controller_object,$method),array());
        }
        else{
            echo "no method";
        }
        
    }
}

