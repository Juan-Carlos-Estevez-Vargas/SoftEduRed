<?php 
	class attendant	{
		private $pdo;

		// Constructor de clase encargado de generar la conexion a la base de datos
		public function __CONSTRUCT() {
			try {
				// Conectando a la base de datos
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		// Método encargado de registrar attendant
		public function registrar($tdoc,$id_user,$relation)	{
			// Sentencia SQL
			$sql = "INSERT INTO attendant (user_pk_fk_cod_doc,user_id_user,fk_relationship) VALUES('$tdoc','$id_user','$relation')";
			// Ejecutando la sentencia SQL
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		// Método encargado de actualizar attendant
		public function actualizar($tdoc,$tdoc2,$id_user,$id_user2,$relation,$relation2) {
			// Sentencia SQL
			$sql ="UPDATE attendant SET user_pk_fk_cod_doc = '$tdoc', user_id_user = '$id_user',fk_relationship = '$relation' WHERE user_pk_fk_cod_doc = '$tdoc2' && user_id_user = '$id_user2' && fk_relationship = '$relation2'";
			// Ejecutando sentencia SQL
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		// Método encargado de eliminar attendant
		public function eliminar($tdoc,$id_user,$relation) {
			// Sentencia SQL
			$sql = "DELETE FROM attendant WHERE user_pk_fk_cod_doc = '$tdoc' && user_id_user = '$id_user' && fk_relationship = '$relation'";
			// Ejecutando sentencia SQL
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}
 ?>
