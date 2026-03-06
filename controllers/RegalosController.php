<?php
namespace Controllers;
use MVC\Router;

Class RegalosController{
    public static function index(Router $router){
        $router-> render("admin/regalos/index",[
            "titulo"=> "Regalos"

        ]);

    }

}