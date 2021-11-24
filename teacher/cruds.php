<?php 
	class teacher {
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($tdoc_t,$id_user_t,$salary) {
			$sql = "INSERT INTO teacher (user_pk_fk_cod_doc,user_id_user,SALARY) VALUES('$tdoc_t','$id_user_t','$salary')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($tdoc_t,$tdoc_t2,$id_user_t,$id_user_t2,$salary)	{ 
			$sql ="UPDATE teacher SET user_pk_fk_cod_doc = '$tdoc_t', user_id_user = '$id_user_t', SALARY = '$salary' WHERE user_pk_fk_cod_doc = '$tdoc_t2' && user_id_user = '$id_user_t2'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($tdoc_t,$id_user_t) {
			$sql = "DELETE FROM teacher WHERE user_pk_fk_cod_doc = '$tdoc_t' && user_id_user = '$id_user_t'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
