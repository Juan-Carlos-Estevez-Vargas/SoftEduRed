<?php
	require_once '../utils/Message.php';

	class SubjectDAO
	{
		private $pdo;

		/**
		* Initializes a new instance of the class and connects it to the database.
		*
		* @throws PDOException if there is an error connecting to the database.
		*/
		public function __construct() {
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a subject with the given parameters
		 *
		 * @param string $subject The name of the subject
		 * @param string $teacherId The ID of teacher
		 *
		 * @return void
		 */
		public function register(string $subject, string $teacherId)
		{
				try {
						$query = "
								INSERT INTO subject	(
										description,
										teacher_id,
										state)
								VALUES (
										UPPER(:description),
										:teacher,
										1);
						";
						$statement = $this->pdo->prepare($query);
						$statement->execute([
								'description' => $subject,
								'teacher' => $teacherId,
						]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectView.php'
						);
				}
		}

		/**
		 * Updates subject information in the database.
		 *
		 * @param string $idSubject The ID of the subject to be updated.
		 * @param string $subject The new name of the subject.
		 * @param string $state The new state of the subject.
		 * @param int $teacherId The ID of the teacher assigned to the subject.
		 *
		 * @return void
		 */
		public function update(
			string $idSubject, string $subject, string $state, int $teacherId)
		{
				try {
						$sql = "
								UPDATE
										subject
								SET
										description = UPPER(:description),
										state = :state,
										teacher_id = :teacherId
								WHERE
										id_subject = :id
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->bindParam(':description', $subject);
						$stmt->bindParam(':state', $state);
						$stmt->bindParam(':teacherId', $teacherId);
						$stmt->bindParam(':id', $idSubject);
						$stmt->execute();
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectView.php'
						);
				}
		}

		/**
		 * Deletes a subject from the database.
		 *
		 * @param string $subjectId The ID of the subject to be deleted.
 		 * @return void
		 */
		public function delete(string $subjectId): void
		{
				try {
						$sql = "UPDATE subject SET state = 3 WHERE id_subject = ?";
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([$subjectId]);
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectView.php'
						);
				}
		}

		public  function isRegistered(
			string $subject,
			int $teacherId
		): bool
		{
			$findRegister = "
				SELECT COUNT(*) FROM subject
				WHERE teacher_id = ? AND description = ? AND state != 3
			";
		
			$stmt = $this->pdo->prepare($findRegister);
			$stmt->execute([$teacherId, $subject]);

			return $stmt->fetchColumn() > 0;
		}
	}
?>