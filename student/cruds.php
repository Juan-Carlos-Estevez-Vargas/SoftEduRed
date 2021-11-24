<?php 
	class student {
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($tdoc_t,$id_user_t,$id_atte,$tdoc_att,$stu_course) {
			$sql = "INSERT INTO student (pk_fk_user_id,pk_fk_tdoc_user,fk_attendant_id,fk_attendat_cod_doc,fk_cod_course) VALUES('$id_user_t','$tdoc_t','$id_atte','$tdoc_att','$stu_course')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($tdoc_t,$id_user_t,$id_atte,$tdoc_att,$stu_course,$tdoc_t2,$id_user_t2,$id_atte2,$tdoc_att2,$stu_course2) {
			$sql ="UPDATE student SET pk_fk_user_id = '$id_user_t', pk_fk_tdoc_user = '$tdoc_t',fk_attendant_id = '$id_atte', fk_attendat_cod_doc ='$tdoc_att', fk_cod_course = '$stu_course' WHERE pk_fk_user_id = '$id_user_t2' && pk_fk_tdoc_user = '$tdoc_t2' &&fk_attendant_id = '$id_atte2' && fk_attendat_cod_doc ='$tdoc_att2' && fk_cod_course = '$stu_course2'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($tdoc_t,$id_user_t,$id_atte,$tdoc_att,$stu_course)	{
			$sql = "DELETE FROM student WHERE pk_fk_user_id = '$id_user_t' && pk_fk_tdoc_user = '$tdoc_t' && fk_attendant_id = '$id_atte' && fk_attendat_cod_doc ='$tdoc_att' && fk_cod_course = '$stu_course'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
