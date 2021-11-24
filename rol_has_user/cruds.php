<?php 
	class rol_user	{
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($tdoc_r,$id_user_r) {
			try {
				$stm1 = $this->pdo->prepare("SELECT * FROM role");
				$stm1->execute();
				foreach ($stm1->fetchAll(PDO::FETCH_OBJ) as $row){
					$rol =  $row->desc_role;
					if (isset($_POST[$rol])) {
						$state="state_".$rol;
						$state_r=$_REQUEST[$state];
						$sql1 = "INSERT INTO user_has_role (tdoc_role,pk_fk_id_user,pk_fk_role,state) VALUES ('$tdoc_r','$id_user_r','$rol','$state_r')";
						$this->pdo->query($sql1);
					}
				}
				print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
			} catch (Exception $e){
				print "<script>alert('Registro FALLIDO.'); window.location='formu_view.php';</script>";
			}
		}

		public function actualizar($tdoc_r,$tdoc_r2,$id_user_r,$id_user_r2,$role,$role2,$state)	{ 
			$sql ="UPDATE user_has_role SET tdoc_role = '$tdoc_r', pk_fk_id_user = '$id_user_r',pk_fk_role = '$role', state = '$state' WHERE tdoc_role = '$tdoc_r2' && pk_fk_id_user = '$id_user_r2' && pk_fk_role = '$role2'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($tdoc_r,$id_user_r,$role) {
			$sql = "DELETE FROM user_has_role WHERE tdoc_role = '$tdoc_r' && pk_fk_id_user = '$id_user_r' && pk_fk_role = '$role'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
