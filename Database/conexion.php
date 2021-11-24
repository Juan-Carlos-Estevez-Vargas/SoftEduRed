<?php

class database{

	// Variables encapsuladas
 	private static $dbhost = "localhost";
	private static $dbname = "proyecto";
	private static $dbuser = "root";
	private static $dbpass = "";

	public static function conectar(){
		try {
			// Creando la conexion con la libreria PDO
			$con = new PDO("mysql:host=".self::$dbhost.";dbname=".self::$dbname,self::$dbuser,self::$dbpass);
			$con ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return $con;
		} catch (Exception $e) {
			// En case de que algo salga mal, se mata la conexion
			die($e->getMessage());
		}
	}
}

?>