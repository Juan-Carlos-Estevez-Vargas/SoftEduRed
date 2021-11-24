<?php 
	class relationship	{
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($relation,$state)	{
			$sql = "INSERT INTO relationship (desc_relationship,state) VALUES(UPPER('$relation'),'$state')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($relation,$queryy,$state) {
			$sql ="UPDATE relationship SET desc_relationship = UPPER('$relation'), state = '$state' 
				WHERE desc_relationship = '$queryy'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($relation)	{
			$sql = "DELETE FROM relationship WHERE desc_relationship = '$relation'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
