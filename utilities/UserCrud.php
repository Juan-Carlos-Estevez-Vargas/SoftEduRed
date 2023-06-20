<?php 
	class UserCrud {
		private $pdo;

		// Creando la conexion a la base de datos
		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		// Actualizando user
		public function updateUser($tdoc,$id_user,$f_name,$s_name, $f_lname,$s_lname,$gender,$adress,
									$email,$phone,$u_name,$pass,$s_ans,$s_ques) {
			$sql ="UPDATE user SET first_name= '$f_name', second_name = '$s_name', surname = '$f_lname', 
					second_surname = '$s_lname', `fk_gender`= '$gender', adress = '$adress', email = '$email', 
					phone = '$phone', user_name = '$u_name', pass = '$pass', security_answer = '$s_ans', 
					fk_s_question = '$s_ques' WHERE pk_fk_cod_doc = '$tdoc' AND id_user = '$id_user'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='marco.php';</script>";
		}
	}

 ?>
