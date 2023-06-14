<?php
	class Attendant
	{
		private $pdo;

		/**
		 * Class constructor for establishing a database connection.
		 *
		 * @throws Exception if the connection fails.
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
		 * Registers an attendant with the given document type, user ID, and relationship.
		 *
		 * @param string $documentType The document type of the user.
		 * @param int $userId The ID of the user.
		 * @param string $relationship The relationship of the attendant to the user.
		 * @return void
		 */
		public function registerAttendant(string $documentType, int $userId, string $relationship) {
			// Prepare SQL statement with parameters
			$stmt = $this->pdo->prepare(
				"INSERT INTO attendant
					(user_pk_fk_cod_doc, user_id_user, fk_relationship)
				VALUES (?, ?, ?)"
			);
			
			// Bind parameters to statement
			$stmt->bindParam(1, $documentType);
			$stmt->bindParam(2, $userId);
			$stmt->bindParam(3, $relationship);
			
			// Execute the statement
			$stmt->execute();
			
			// Alert the user that the registration was successful and redirect to the form view
			echo "<script>
				alert('Registration successfully added.');
				window.location='form_view.php';
			</script>";
		}

		/**
		 * Updates an attendant with new user data and relationship.
		 *
		 * @param string $newDocType The new user document type code.
		 * @param string $currentDocType The current user document type code.
		 * @param int $newUserId The new user ID.
		 * @param int $currentUserId The current user ID.
		 * @param string $newRelation The new relationship code.
		 * @param string $currentRelation The current relationship code.
		 * @return void
		 */
		public function updateAttendant(
			string $newDocType, string $currentDocType, int $newUserId,
			int $currentUserId, string $newRelation, string $currentRelation
		)	{
			// SQL statement to update the attendant
			$sql = "UPDATE attendant SET
									user_pk_fk_cod_doc = '$newDocType',
									user_id_user = '$newUserId',
									fk_relationship = '$newRelation'
							WHERE user_pk_fk_cod_doc = '$currentDocType' &&
									user_id_user = '$currentUserId' &&
									fk_relationship = '$currentRelation'";
			
			// Execute the SQL statement
			$this->pdo->query($sql);
			
			// Show success message and redirect to form view
			print "<script>
				alert('Registro Actualizado Exitosamente.');
				window.location='formu_view.php';
			</script>";
		}

		/**
		 * Deletes an attendant by their document code, user ID, and relationship code.
		 *
		 * @param string $docCode The document code of the user.
		 * @param int $userId The user's ID.
		 * @param int $relationCode The relationship code of the attendant.
		 * @return void
		 */
		public function deleteAttendant(string $docCode, int $userId, int $relationCode)
		{
			$sql = "DELETE FROM attendant
							WHERE user_pk_fk_cod_doc = '$docCode' &&
									user_id_user = '$userId' &&
									fk_relationship = '$relationCode'";

			$this->pdo->query($sql);

			print "<script>
				alert('Record Deleted Successfully.');
				window.location='formu_view.php';
			</script>";
		}
	}
?>
