<?php 

	class no_attendance
	{
		private $pdo;
		public function __CONSTRUCT()
		{
			try {
				$this->pdo = database::conectar();

			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($tdoc,$id,$subject,$course)
		{

			$stm1 = $this->pdo->prepare("SELECT * FROM student");
             $stm1->execute();
         
             foreach($stm1->fetchAll(PDO::FETCH_OBJ) as $row) 
             {
              
              $id_student = $row->pk_fk_user_id;
              
              if(isset($_POST[$id_student]))
              {
                $sql = "INSERT INTO no_attendance (date,fk_student_tdoc,fk_student_user_id,fk_course_has_subject,fk_sub_has_course) VALUES (NOW(),'$tdoc','$id_student','$course','$subject')";
               
                $this->pdo->query($sql);
              }
             }
         
                print "<script>alert(\"Registro Agregado exitosamente. \");window.location='formu_view.php';</script>";


		}

		public function actualizar($gender,$queryy,$estate)
		{

			$sql ="UPDATE gender SET desc_gender = UPPER('$gender'), state = '$estate' WHERE desc_gender = '$queryy'";

			$this->pdo->query($sql);

			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";

		}

		public function eliminar($gender)
		{

			$sql = "DELETE FROM gender WHERE desc_gender = '$gender'";

			$this->pdo->query($sql);

			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
