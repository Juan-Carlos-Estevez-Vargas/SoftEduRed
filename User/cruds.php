<?php 
	class user_cruds {
		private $pdo;

		public function __CONSTRUCT()	{
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($tdoc,$id_user,$f_name,$s_name,$f_lname,$s_lname,$gender,$adress,$email,$phone,$u_name,$pass,$s_ans,$s_ques) {   
			$sql = "INSERT INTO user (pk_fk_cod_doc, id_user, first_name, second_name, surname, second_surname, `fk_gender`, adress, email, phone, user_name, pass, security_answer, `fk_s_question`) VALUES ('$tdoc','$id_user','$f_name','$s_name','$f_lname','$s_lname','$gender','$adress','$email','$phone','$u_name','$pass','$s_ans','$s_ques')";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($tdoc,$id_user,$f_name,$s_name, $f_lname,$s_lname,$gender,$adress,$email,$phone,$u_name,$pass,$s_ans,$s_ques) {
			$sql ="UPDATE user SET first_name= '$f_name', second_name = '$s_name', surname = '$f_lname', second_surname = '$s_lname', `fk_gender`= '$gender', adress = '$adress', email = '$email', phone = '$phone', user_name = '$u_name', pass = '$pass', security_answer = '$s_ans', fk_s_question = '$s_ques' WHERE pk_fk_cod_doc = '$tdoc' AND id_user = '$id_user'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($id_user,$tdoc) {
			$sql = "DELETE FROM user WHERE id_user = '$id_user' AND pk_fk_cod_doc = '$tdoc'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
