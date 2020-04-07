<?php
    class DB{
        private $host = '127.0.0.1';
        private $usuario = 'admin';
        private $senha = 'X01nn@h77M';
        private $database = 'HelpDesk';

        public function connecta_mysql(){
            $con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
            mysqli_set_charset($con,'utf8');

            if(mysqli_connect_errno()){
                header('Location: ../PageError/dbError.php');
            }
            return $con;
        }
    }
?>