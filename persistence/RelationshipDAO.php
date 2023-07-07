<?php
 	require_once '../utils/Message.php';

	class RelationshipDAO
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class by setting up a PDO connection to the database
		 *
		 * @throws PDOException if there is an error connecting to the database
		 */
		public function __construct()
		{
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a new relationship with the given description and state.
		 *
		 * @param string $description The description of the relationship to be registered.
		 * @param string $state The state of the relationship to be registered.
		 * @return void
		 */
		public function register(string $description, string $state): void
		{
				try {
						$query = "
								INSERT INTO relationship (description, state)
								VALUES (UPPER(:description), :state)
						";
	
						$statement = $this->pdo->prepare($query);
						$statement->bindParam(':description', $description);
						$statement->bindParam(':state', $state);
						$statement->execute();
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationshipView.php'
						);
				}
		}

		/**
		 * Update a record in the 'relationship' table.
		 *
		 * @param string $idRelationship The id of the record to update.
		 * @param string $relationship The new value for 'description'.
		 * @param string $state The new value for 'state'.
		 *
		 * @throws Exception If there is an error updating the record.
		 *
		 * @return void
		 */
		public function update(string $idRelationship, string $state)
		{
				try {
						// Update the record in the database
						$sql = "
								UPDATE relationship
								SET state = :state
								WHERE id_relationship = :id
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([
								'state' => $state,
								'id' => $idRelationship
						]);
				} catch (Exception $e) {
						// Show error message if there is an error updating the record
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationshipView.php'
						);
						throw $e;
				}
		}

		/**
		 * Deletes a record from the relationship table based on the description of the relationship.
		 *
		 * @param string $idRelationship The ID of the relationship to delete.
		 * @return void
		 */
		public function delete(string $idRelationship): void
		{
				try {
						$sql = "
							UPDATE relationship
							SET state = 3
							WHERE id_relationship = :id
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->bindParam(':id', $idRelationship, PDO::PARAM_STR);
						$stmt->execute();
				} catch (Exception $e) {
						// Show error message and redirect to relationship view
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/relationshipView.php'
						);
				}
		}
	}
?>