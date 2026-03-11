<?php

    class conexion_bd{

        private $server;
        private $db;
        private $user;
        private $pass;
        private $conn;

        public function __construct(){
            $this->server = 'localhost';
            $this->db = 'pagina_web';
            $this->user = 'root';
            $this->pass = '';
            $this->conn = new mysqli($this->server,$this->user, $this->pass,  $this->db);
            if($this->conn->connect_errno){
                die('Ha ocurrido un error al conectar: '.$this->conn->connect_errno);
            }
        }

        public function consultar($query){
                return $this->conn->query($query);
        }

    }


?>