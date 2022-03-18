<?php

namespace Model;

class CitaServicio extends ActiveRecord{

    protected static $tabla = 'citasServicios';
    //sirve para normalizar los datos
    protected static $columnasDB = ['id', 'citaId', 'serviciosId'];
    
    public $id;
    public $citasId;
    public $serviciosId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->citasId = $args['citaId'] ?? '';
        $this->serviciosId = $args['serviciosId'] ?? '';
    }
}