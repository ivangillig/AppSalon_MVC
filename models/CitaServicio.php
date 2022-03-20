<?php

namespace Model;

class CitaServicio extends ActiveRecord{

    protected static $tabla = 'citasServicios';
    //sirve para normalizar los datos
    protected static $columnasDB = ['id', 'citaId', 'servicioId'];
    
    public $id;
    public $citaId;
    public $serviciosId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
    }
}