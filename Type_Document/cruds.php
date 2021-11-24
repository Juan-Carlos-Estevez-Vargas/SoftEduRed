<?php 
	class type_of_document {
		private $pdo;

		public function __CONSTRUCT() {
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		public function registrar($doc,$desc_doc) {
			$sql = "INSERT INTO type_of_document (cod_document,Des_doc) VALUES (UPPER('$doc'), UPPER('$desc_doc'))";
			$this->pdo->query($sql);
			print "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function actualizar($doc,$queryy,$desc_doc)	{
			$sql ="UPDATE type_of_document SET cod_document = UPPER ('$doc'), Des_doc = UPPER ('$desc_doc') 
			WHERE cod_document = '$queryy'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
		}

		public function eliminar($doc)	{
			$sql = "DELETE FROM type_of_document WHERE cod_document = '$doc'";
			$this->pdo->query($sql);
			print "<script>alert('Registro Eliminado Exitosamente.'); window.location='formu_view.php';</script>";
		}

	}

 ?>
