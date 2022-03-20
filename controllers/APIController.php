<?php

namespace Controllers;

use Model\Servicio;
use Model\CitaServicio;
use Model\Cita;

class APIController {
    public static function index(){
        //Consulto los servicios a la DB
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    public static function guardar() {

        //Guarda la cita en DB y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        //Guarda la cita y los servicios


        //guarda los servicios con el ID de la cita
        $idServicios = explode(",", $_POST['servicios']);
        $resultado = [
            'servicios' => $idServicios
        ];

        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        //retornamos una respuesta
        echo json_encode(['resultado'=>$resultado]);

        }

        public static function eliminar(){
            
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $id = $_POST['id'];

                $cita = Cita::find($id);

                $cita->eliminar();
                header('Location:' . $_SERVER['HTTP_REFERER']);

            }
        }
}