<?php
	class Database
	{
		// Variables encapsuladas
		private static $dbhost = "localhost";
		private static $dbname = "proyecto";
		private static $dbuser = "root";
		private static $dbpass = "";

		/**
		 * Connects to the database and returns a PDO object.
		 *
		 * @return PDO object representing the database connection.
		 */
		public static function conectar()
		{
			try {
				$dsn = "mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname;
				$options = [
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
				];
				return new PDO($dsn, self::$dbuser, self::$dbpass, $options);
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
	}
?>