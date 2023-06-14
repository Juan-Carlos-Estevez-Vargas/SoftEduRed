<?php
	class Student
	{
		private $pdo;

		/**
		 * Constructor for the class.
		 * Attempts to establish a connection to the database using PDO.
		 *
		 * @throws Exception if unable to establish a connection to the database.
		 */
		public function __construct()
		{
			try {
				$this->pdo = new PDO($dsn, $username, $password, $options);
			} catch (PDOException $e) {
				throw new PDOException("Unable to establish a connection to the database: " . $e->getMessage());
			}
		}

		/**
		 * Registers a new student in the database.
		 *
		 * @param string $studentIdType The ID type of the student.
		 * @param int $studentUserId The user ID of the student.
		 * @param int $attendantId The attendant ID.
		 * @param string $attendantIdType The ID type of the attendant.
		 * @param int $studentCourseId The course ID of the student.
		 * @return void
		 */
		public function registerStudent(
			string $studentIdType, int $studentUserId, int $attendantId,
			string $attendantIdType, int $studentCourseId
		) {
			$sql = "INSERT INTO
								student (pk_fk_user_id, pk_fk_tdoc_user, fk_attendant_id, fk_attendat_cod_doc, fk_cod_course)
							VALUES (?, ?, ?, ?, ?)";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
					$studentUserId, $studentIdType, $attendantId,
					$attendantIdType,$studentCourseId
				]);
			
			// Print success message and redirect
			print "<script>
				alert('Registro Actualizado Exitosamente.');
				window.location='formu_view.php';
			</script>";
		}

		/**
		 * Update the student's information.
		 *
		 * @param string $studentDocType The type of document of the student to be updated.
		 * @param int $studentId The ID of the student to be updated.
		 * @param int $attendantId The ID of the attendant to be updated.
		 * @param string $attendantDocType The type of document of the attendant to be updated.
		 * @param int $studentCourse The course code of the student to be updated.
		 * @param string $studentDocType2 The type of document of the student to be replaced.
		 * @param int $studentId2 The ID of the student to be replaced.
		 * @param int $attendantId2 The ID of the attendant to be replaced.
		 * @param string $attendantDocType2 The type of document of the attendant to be replaced.
		 * @param int $studentCourse2 The course code of the student to be replaced.
		 * @return void
		 */
		public function updateStudent(
			string $studentDocType, int $studentId, int $attendantId, string $attendantDocType,
			int $studentCourse,	string $studentDocType2, int $studentId2, int $attendantId2,
			string $attendantDocType2, int $studentCourse2
		) {
			// Prepare SQL statement with placeholders
			$sql = "UPDATE student SET
									pk_fk_user_id = ?,
									pk_fk_tdoc_user = ?,
									fk_attendant_id = ?,
									fk_attendat_cod_doc =?,
									fk_cod_course = ?
							WHERE
									pk_fk_user_id = ? &&
									pk_fk_tdoc_user = ? &&
									fk_attendant_id = ? &&
									fk_attendat_cod_doc =? &&
									fk_cod_course = ?";

			// Execute prepared statement with sanitized values
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(
				[$studentId, $studentDocType, $attendantId, $attendantDocType,
					$studentCourse, $studentId2, $studentDocType2, $attendantId2,
					$attendantDocType2, $studentCourse2
				]);

			// Print success message and redirect
			print "<script>
				alert('Registro Actualizado Exitosamente.');
				window.location='formu_view.php';
			</script>";
		}

		/**
		 * Deletes a student record from the database based on user ID, document type, attendant ID,
		 * document type of attendant, and course code.
		 *
		 * @param string $userDocType Document type of the user.
		 * @param int $userId User ID.
		 * @param int $attendantId Attendant ID.
		 * @param string $attendantDocType Document type of the attendant.
		 * @param string $courseCode Course code.
		 * @return void
		 */
		public function deleteStudent(
			string $userDocType, int $userId, int $attendantId,
			string $attendantDocType, string $courseCode)
		{
			$sql = "DELETE FROM student WHERE
							pk_fk_user_id = '$userId' AND
							pk_fk_tdoc_user = '$userDocType' AND
							fk_attendant_id = '$attendantId' AND
							fk_attendat_cod_doc = '$attendantDocType' AND
							fk_cod_course = '$courseCode'";
			$this->pdo->query($sql);

			print "<script>
				alert('Registro Eliminado Exitosamente.');
				window.location='formu_view.php';
			</script>";
		}

	}
?>
