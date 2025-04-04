<?php
    require_once 'DataBase.php';

    /**
     * Clase para manejar operaciones de productos en la base de datos
     */
    class Create extends DataBase {
        protected $data = [];

        public function __construct($db, $user = 'root', $pass = '7*Vl*zwyPeGlNLTm') {
            parent::__construct($db, $user, $pass);
            $this->data = [];
        }
    }
?>