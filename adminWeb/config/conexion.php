﻿<?php 

 class Conexion extends PDO { 
   private $tipo_de_base = 'mysql';
   private $host = '192.168.1.8';
   private $nombre_de_base = 'agencia';
   private $charset='utf8mb4';
   private $usuario = 'dev';
   private $contrasena = 'dev123'; 

   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
<<<<<<< HEAD
         parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
=======
         parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
>>>>>>> fd313089866711210d8a45ab2649e33a6d886486
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   } 
 } 

?>