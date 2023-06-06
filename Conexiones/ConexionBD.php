<?php
class Conexion{
    public static function IniciarConexion(){
        $conexion = new PDO("mysql:Servidor=127.0.0.1;dbname=tec;charset=utf8", "root", "");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }  
} 