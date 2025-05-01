<?php namespace myapi\Create;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Create extends DataBase {

        public function __construct($db, $user = 'root', $pass = '7*Vl*zwyPeGlNLTm') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

        public function add($producto) {
            // Ya es un objeto stdClass, no uses json_decode aquí
        
            $nombre = $this->conexion->real_escape_string($producto->nombre);
            $marca = $this->conexion->real_escape_string($producto->marca);
            $modelo = $this->conexion->real_escape_string($producto->modelo);
            $precio = floatval($producto->precio);
            $detalles = $this->conexion->real_escape_string($producto->detalles);
            $unidades = intval($producto->unidades);
            $imagen = $this->conexion->real_escape_string($producto->imagen);
        
            $query = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                      VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen')";
        
            $result = $this->conexion->query($query);
            $nuevoId = $this->conexion->insert_id;
        
            $this->data = $result
                ? ['status' => 'success', 'message' => 'Producto agregado correctamente', 'id' => $nuevoId]
                : ['status' => 'error', 'message' => $this->conexion->error];
        }
        
    }
?>