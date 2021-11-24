<?php 
	class subj_course {
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($course) {
			try {
				$stm1 = $this->pdo->prepare("SELECT * FROM subject");
				$stm1->execute();
				foreach ($stm1->fetchAll(PDO::FETCH_OBJ) as $row){
					$subject =  $row->n_subject;				
					if (isset($_POST[$subject])) {
						$state="state_".$subject;
						$state_s=$_REQUEST[$state];
						$sql1 = "INSERT INTO subject_has_course (pk_fk_te_sub,pk_fk_course_stu, state_sub_course) VALUES ('$subject','$course','$state_s')";
						$this->pdo->query($sql1);
					}
				}		
				print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
			} catch (Exception $e){
				print "<script>alert('Registro FALLIDO.'); window.location='formu_view.php';</script>";
			}
		}

		public function actualizar($subj,$subj2,$course,$course2,$state) {
			$sql ="UPDATE subject_has_course SET pk_fk_te_sub = '$subj', pk_fk_course_stu = '$course', 
				state_sub_course = '$state' WHERE pk_fk_te_sub = '$subj2' && pk_fk_course_stu = '$course2'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($subj,$course)	{
			$sql = "DELETE FROM subject_has_course WHERE pk_fk_te_sub = '$subj' && pk_fk_course_stu = '$course'" ;
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
