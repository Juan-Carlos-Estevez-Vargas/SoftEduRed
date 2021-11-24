<?php 
	class course {
		private $pdo;

		public function __CONSTRUCT()
		{
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($course,$state) {
			$sql = "INSERT INTO course (cod_course,state) VALUES(UPPER('$course'),'$state')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($course,$queryy,$state) {
			$sql ="UPDATE course SET cod_course = UPPER('$course'), state = '$state' WHERE cod_course = '$queryy'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($course) {
			$sql = "DELETE FROM course WHERE cod_course = '$course'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}
	}
 ?>
