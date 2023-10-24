<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/ponentes?page=1');
        }

        $registros_por_pagina = 5; 
        $total_registros = Ponente::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());

        if($paginacion->totalPaginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }

        if(!isAdmin()) {
            header('location: /login');
        }

        $router->render('admin/ponentes/index', [
            'titulo' => 'Conferenecistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router) {
    
        $alertas = [];
        $ponente = new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                
                $carpeta_imagenes = '../public/img/speakers';
                //Crear carpeta
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }

                $img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);

            //Validar
            $alertas = $ponente->validar();

            //Guardar
            if(empty($alertas)) {
                $img_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png" );
                $img_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp" );

                //Guardar db
                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router) {

        if(!isAdmin()) {
            header('location: /login');
        }

        $alertas = [];
        
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/ponentes');
        }

        $ponente = Ponente::find($id);

        if(!$ponente) {
            header('Location: /admin/ponentes');
        }

        $ponente->imagenActual = $ponente->imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!isAdmin()) {
                header('location: /login');
            }

            //Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
    
                $carpeta_imagenes = '../public/img/speakers';
                //Crear carpeta
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }

                $img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagenActual;
            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    $img_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png" );
                    $img_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp" );
                }

                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $redes = json_decode($ponente->redes);

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function eliminar() {

        if(!isAdmin()) {
            header('location: /login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $ponente = Ponente::find($id);

            if(isset($ponente)) {
                header('Location: /admin/ponentes');
            }
            $resultado = $ponente->eliminar();

            if($resultado) {
                header('Location: /admin/ponentes');
            }
        }
    }
}