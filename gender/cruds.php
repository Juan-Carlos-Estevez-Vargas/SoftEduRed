<?php 
	class gender {
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($gender, $estate)	{
			$sql = "INSERT INTO gender(desc_gender,state) VALUES(UPPER('$gender'),'$estate')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($gender,$queryy,$estate)	{
			$sql ="UPDATE gender SET desc_gender = UPPER('$gender'), state = '$estate' WHERE desc_gender = '$queryy'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($gender) {
			$sql = "DELETE FROM gender WHERE desc_gender = '$gender'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
