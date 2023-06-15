<?php
	class Subject
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
		 * @param string $state The state of the subject
		 * @param string $documentType The type of document of the user
		 * @param int $userId The ID of the user
		 *
		 * @return void
		 */
		public function registerSubject(string $subject, string $state, string $documentType, int $userId)
		{
			$query = "INSERT INTO `subject` (`n_subject`, `state`, `fk_id_user_teacher`, `fk_tdoc_user_teacher`)
								VALUES (UPPER(:subject), :state, :userId, :documentType)";
			$statement = $this->pdo->prepare($query);
			$statement->execute([
					'subject' => $subject,
					'state' => $state,
					'userId' => $userId,
					'documentType' => $documentType
			]);
			echo "
				<script>
					alert('Registro Agregado Exitosamente.');
					window.location='formu_view.php';
				</script>
			";
		}

		/**
		 * Updates subject information in the database.
		 *
		 * @param string $newSubject The new subject name.
		 * @param string $newState The new subject state.
		 * @param string $teacherDocumentType The teacher's document type.
		 * @param int $teacherId The teacher's ID in the database.
		 * @param string $currentSubject The current name of the subject to be updated.
		 *
		 * @return void
		 */
		public function updateSubject(
			string $newSubject, string $newState, string $teacherDocumentType,
			int $teacherId, string $currentSubject)
		{
			$sql = "
				UPDATE subject
				SET n_subject = UPPER(:newSubject),
						state = :newState,
						fk_id_user_teacher = :teacherId,
						fk_tdoc_user_teacher = :teacherDocumentType
				WHERE n_subject = :currentSubject
			";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':newSubject', $newSubject);
			$stmt->bindParam(':newState', $newState);
			$stmt->bindParam(':teacherId', $teacherId);
			$stmt->bindParam(':teacherDocumentType', $teacherDocumentType);
			$stmt->bindParam(':currentSubject', $currentSubject);
			$stmt->execute();

			print "
				<script>
					alert('Registro Actualizado Exitosamente.');
					window.location='formu_view.php';
				</script>
			";
		}

		/**
		 * Deletes a subject from the database.
		 *
		 * @param string $subject The name of the subject to be deleted.
		 */
		public function deleteSubject(string $subject)
		{
			$sql = "DELETE FROM subject WHERE n_subject = ?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$subject]);
			
			echo "
				<script>
					alert('Registro Eliminado Exitosamente.');
					window.location='formu_view.php';
				</script>
			";
		}
	}
?>