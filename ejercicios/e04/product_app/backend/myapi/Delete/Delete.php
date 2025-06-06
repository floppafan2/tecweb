<?php namespace myapi\Delete;
    
    use myapi\DataBase;

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Delete extends DataBase {

        public function __construct($db, $user = 'root', $pass = '7*Vl*zwyPeGlNLTm') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }

        public function delete($id) {
            $query = "UPDATE productos SET eliminado=1 WHERE id = '$id'";
            $result = $this->conexion->query($query);
            if ($result) {
                $this->data = ['status' => 'success', 'message' => 'Producto eliminado correctamente'];
            } else {
                $this->data = ['status' => 'error', 'message' => $this->conexion->error];
            }
        }
    }
?>