<?php
	class Teacher
	{
		private $pdo;

		/**
		 * Initializes the PDO object.
		 */
		public function __construct()
		{
			try {
				$this->pdo = Database::connect();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		/**
		 * Registers a teacher in the database.
		 *
		 * @param string $docType - The teacher's document type.
		 * @param string $userId - The teacher's user ID.
		 * @param float $salary - The teacher's salary.
		 * @return void
		 */
		public function registerTeacher(string $docType, string $userId, float $salary)
		{
			$sql = "INSERT INTO teacher	(user_pk_fk_cod_doc, user_id_user, SALARY)
							VALUES (:doc_type, :user_id, :salary)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
				'doc_type' => $docType,
				'user_id' => $userId,
				'salary' => $salary
			]);
			print "<script>
				alert('Registro Agregado Exitosamente.');
				window.location='../views/roles/teacherView.php';
			</script>";
		}

		/**
		 * Updates a teacher's information in the database.
		 *
		 * @param string $newDocType The new document type of the teacher.
		 * @param string $currentDocType The current document type of the teacher.
		 * @param int $newUserId The new user ID of the teacher.
		 * @param int $currentUserId The current user ID of the teacher.
		 * @param float $newSalary The new salary of the teacher.
		 *
		 * @return void
		 */
		public function updateTeacherInfo(
			string $newDocType, string $currentDocType, int $newUserId,
			int $currentUserId, float $newSalary)
		{
			$sql = "UPDATE teacher
							SET user_pk_fk_cod_doc = ?, user_id_user = ?, SALARY = ?
							WHERE user_pk_fk_cod_doc = ? && user_id_user = ?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$newDocType, $newUserId, $newSalary, $currentDocType, $currentUserId]);

			print "<script>
				alert('Teacher's information updated successfully.');
				window.location='../views/roles/teacherView.php';
			</script>";
		}

		/**
		 * Deletes a teacher record from the database based on their document type and user ID.
		 *
		 * @param string $documentType The document type of the teacher.
		 * @param int $userId The user ID of the teacher.
		 *
		 * @return void
		 */
		public function deleteTeacher(string $documentType, int $userId): void {
			$sql = "DELETE FROM teacher WHERE user_pk_fk_cod_doc = :documentType AND user_id_user = :userId";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(['documentType' => $documentType, 'userId' => $userId]);
			
			echo "<script>
				alert('Registro Eliminado Exitosamente.');
				window.location='../views/roles/teacherView.php';
			</script>";
		}

	}
?>
