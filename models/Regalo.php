<?php

namespace Model;

class Regalo extends ActiveRecord {

    public $nombre;
    public $total;

    protected static $tabla = 'regalos';
    protected static $columnasDB = ['id', 'nombre'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre= $args['nombre'] ?? '';
    }
}