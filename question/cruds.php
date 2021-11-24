<?php 
	class security_question	{
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}
		public function registrar($question,$state)	{
			$sql = "INSERT INTO security_question (question,state) VALUES(UPPER('$question'),'$state')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($question,$state) {
			$sql ="UPDATE security_question SET state = '$state' WHERE question = '$question'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($question)	{
			$sql = "DELETE FROM security_question WHERE question = '$question'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}
	}
 ?>
