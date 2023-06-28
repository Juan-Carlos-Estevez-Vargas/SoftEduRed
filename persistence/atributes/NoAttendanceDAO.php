<?php
	class NoAttendance
	{
		private $pdo;
		
		/**
		 * Initializes the class object by connecting to the database.
		 * Throws an exception if connection fails.
		 */
		public function __construct()
		{
			try {
				$this->pdo = Database::conectar();
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage());
			}
		}

		/**
		 * Registers a student's absence for a specific course and subject.
		 *
		 * @param string $studentId The student's identification document.
		 * @param int $subjectId The ID of the subject.
		 * @param int $courseId The ID of the course.
		 *
		 * @return void
		 */
		public function registerAbsence($studentId, $subjectId, $courseId)
		{
			$stm = $this->pdo->prepare("SELECT * FROM student");
			$stm->execute();
			
			foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $row) {
				$idStudent = $row->pk_fk_user_id;
				
				if (isset($_POST[$idStudent])) {
					$sql = "
						INSERT INTO no_attendance (date,fk_student_tdoc,fk_student_user_id,fk_course_has_subject,fk_sub_has_course)
						VALUES (NOW(),'$studentId','$idStudent','$courseId','$subjectId')
					";
					$this->pdo->query($sql);
				}
			}
				
			print "
				<script>
					alert(\"Registro Agregado exitosamente. \");
					window.location='../views/atributes/noAttendanceView.php';
				</script>
			";
		}

		/**
		 * Update the description and state of a gender in the database.
		 *
		 * @param string $newDesc - The new description of the gender
		 * @param string $oldDesc - The old description of the gender to be updated
		 * @param string $newState - The new state of the gender
		 *
		 * @return void
		 */
		public function updateGender($newDesc, $oldDesc, $newState)
		{
			$sql = "
				UPDATE gender
				SET desc_gender = UPPER(:newDesc),
						state = :newState
				WHERE desc_gender = :oldDesc
			";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':newDesc', $newDesc);
			$stmt->bindParam(':newState', $newState);
			$stmt->bindParam(':oldDesc', $oldDesc);
			$stmt->execute();

			echo "
				<script>
					alert('Registro Actualizado Exitosamente.');
					window.location='../views/atributes/noAttendanceView.php';
				</script>
			";
		}

		/**
		 * Deletes a record from the 'gender' table based on the given gender description.
		 *
		 * @param string $gender The gender description to be deleted.
		 *
		 * @return void
		 */
		public function deleteGender(string $gender)
		{
			$query = "DELETE FROM gender WHERE desc_gender = :gender";
			$statement = $this->pdo->prepare($query);
			$statement->execute([':gender' => $gender]);

			$message = "Registro Eliminado Exitosamente.";
			echo "
				<script>
					alert('$message');
					window.location='../views/atributes/noAttendanceView.php';
				</script>
			";
		}
	}
?>
