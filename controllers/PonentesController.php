<?php
namespace Controllers;

use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Ponentes;
use MVC\Router;

Class PonentesController{
    public static function index(Router $router){
         if(!is_admin()){
            header("Location: /login");
        }

        $pagina_actual = $_GET["page"];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1){
            header("Location: /admin/ponentes?page=1");
        }
        $registros_por_pagina= 10;
        $total= Ponentes::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $ponentes=Ponentes::paginar($registros_por_pagina, $paginacion->offset());
        
        if($paginacion->total_paginas() < $pagina_actual){
            header("Location: /admin/ponentes?page=1");
        }
    
        $total_registros=0;
        //debuguear($ponentes);
        //debuguear($paginacion);
       
        //debuguear(is_admin());

        $router-> render("admin/ponentes/index",[
            "titulo"=> "Ponentes / Conferencistas",
            "ponentes"=>$ponentes,
            "paginacion"=>$paginacion->paginacion()

        ]);

    }

    public static function crear(Router $router){
        
        $alertas= [];
        $ponente = new Ponentes;

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            if(!is_admin()){
            header("Location: /login");
            }

            //leer magen y verificar si hay imagen
            if(!empty($_FILES["imagen"]["tmp_name"])){
                //debuguear("si hay imagen");
                $carpeta_imagens= "../public/img/speakers";

                if(!is_dir($carpeta_imagens)){
                    mkdir($carpeta_imagens, 0755, true); //755 para crear la carpeta y true para darle permiso, si no funciona prueba con 0777
                }

                $imagen_png = Image::make($_FILES["imagen"]["tmp_name"])-> fit(800, 800)->encode("png", 80); //modificacion de una imagen para hecerla 800x800px con calidad de 80
                $imagen_webp = Image::make($_FILES["imagen"]["tmp_name"])-> fit(800, 800)->encode("webp", 80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST["imagen"] = $nombre_imagen;

            }

            $_POST["redes"]= json_encode($_POST["redes"], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);

            //validar
            $alertas= $ponente->validar();

            //guardar el registro
            if(empty($alertas)){
                //guardar imagen
                $imagen_png->save($carpeta_imagens . "/" . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagens . "/" . $nombre_imagen . ".webp");

                //guardar en bd
                $resultado = $ponente->guardar();

                if($resultado){
                    header("Location: /admin/ponentes");
                }
            }
        }
        $redes= json_decode($ponente->redes); //psa de string a Objeto(Json)

        $router-> render("admin/ponentes/crear",[
            "titulo"=> "Registrar Ponente",
            "alertas" => $alertas,
            "ponente" =>$ponente,
            "redes"=>$redes

        ]);

    }

        public static function editar(Router $router){

        $alertas= [];
        //validar id que se pasa por el url
        $id= $_GET["id"];
        $id= filter_var($id, FILTER_VALIDATE_INT);

        if(!$id){
            header("Location: /admin/ponentes");
        }

        //obtener ponente a edtar
        $ponente= Ponentes::find($id);

        if(!$ponente){
            header("Location: /admin/ponentes");
        }

       $ponente->imagen_actual = $ponente->imagen;

       $redes= json_decode($ponente->redes); //psa de string a Objeto(Json)
       //guardar ponente
         if($_SERVER["REQUEST_METHOD"] === "POST"){
         if(!is_admin()){
            header("Location: /login");
         }

            //leer magen y verificar si hay imagen
            if(!empty($_FILES["imagen"]["tmp_name"])){
                //debuguear("si hay imagen");
                $carpeta_imagens= "../public/img/speakers";

                if(!is_dir($carpeta_imagens)){
                    mkdir($carpeta_imagens, 0755, true); //755 para crear la carpeta y true para darle permiso, si no funciona prueba con 0777
                }

                $imagen_png = Image::make($_FILES["imagen"]["tmp_name"])-> fit(800, 800)->encode("png", 80); //modificacion de una imagen para hecerla 800x800px con calidad de 80
                $imagen_webp = Image::make($_FILES["imagen"]["tmp_name"])-> fit(800, 800)->encode("webp", 80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST["imagen"] = $nombre_imagen;

            }else{
                $_POST["imagen"] =$ponente->imagen_actual;
            }
            $_POST["redes"]= json_encode($_POST["redes"], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            $alertas= $ponente->validar();

            if(empty($alertas)){
                if(isset($nombre_imagen)){
                    $imagen_png->save($carpeta_imagens . "/" . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagens . "/" . $nombre_imagen . ".webp");
                }
                $resultado= $ponente->guardar();

                if($resultado){
                    header("Location: /admin/ponentes");
                }
                

            }
       }

        $router-> render("admin/ponentes/editar",[
            "titulo"=> "Editar Ponentes",
            "alertas"=>$alertas,
            "ponente"=>$ponente, 
            "redes"=> $redes

        ]);

    }
     public static function eliminar(){

        if($_SERVER["REQUEST_METHOD"] === "POST"){
             if(!is_admin()){
            header("Location: /login");
            }

            
            $id=$_POST["id"];
            $ponente=Ponentes::find($id);

            if(!isset($ponente)){
                header("Location: /admin/ponentes");
                return;
            }
            
            $resultado= $ponente->eliminar();

            if($resultado){
                header("Location: /admin/ponentes");
            }
        }
     }

}