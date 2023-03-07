<?php
namespace App\Controllers;

class Controller { 
        
    public function view($route,$params = []){
        // destructar array y mostrar en las vistas las variables
        extract($params);
    
        $route=str_replace(".","/",$route);
        
        if(file_exists("../resources/views/$route.php")){
            ob_start();
            include "../resources/views/$route.php";
            $content=ob_get_clean();
            return $content;
        }
        return $route;
    }


    public function redirect($route){
        header("Location: {$route}");
    }
}      
?>