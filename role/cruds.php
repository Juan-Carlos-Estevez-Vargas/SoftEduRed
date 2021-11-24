<?php 
	class role	{
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($relation,$state)	{
			$sql = "INSERT INTO role (desc_role,state) VALUES(UPPER('$relation'),'$state')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($relation,$queryy,$state) {
			$sql ="UPDATE role SET desc_role = UPPER('$relation'), state = '$state' WHERE desc_role = '$queryy'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($relation)	{
			$sql = "DELETE FROM role WHERE desc_role = '$relation'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
