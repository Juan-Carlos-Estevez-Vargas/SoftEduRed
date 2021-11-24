<?php 
	class subject {
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($subject, $state,$tdoc_user,$id_user)	{
			$sql= "INSERT INTO `subject` (`n_subject`, `state`, `fk_id_user_teacher`, `fk_tdoc_user_teacher`) VALUES (UPPER('$subject'),'$state','$id_user', '$tdoc_user')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.');window.location='formu_view.php';</script>";
		}

		public function actualizar($subject,$state,$tdoc_t,$id_user_t,$queryy)	{
			$sql ="UPDATE subject SET n_subject = UPPER('$subject'), state = '$state', fk_id_user_teacher = '$id_user_t', fk_tdoc_user_teacher = '$tdoc_t' WHERE n_subject= '$queryy'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($subject)	{
			$sql = "DELETE FROM subject WHERE n_subject = '$subject'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>