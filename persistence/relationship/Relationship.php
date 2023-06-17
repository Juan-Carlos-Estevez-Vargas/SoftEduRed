<?php
	class Relationship
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
		public function registerRelationship(string $description, string $state): void
		{
			$query = "
				INSERT INTO relationship (desc_relationship, state)
				VALUES (UPPER(:description), :state)
			";
			$statement = $this->pdo->prepare($query);
			$statement->bindParam(':description', $description);
			$statement->bindParam(':state', $state);
			$statement->execute();
			
			$successMessage = 'Registro Agregado Exitosamente.';
			$redirectUrl = 'formu_view.php';
			echo "
				<script>
					alert('$successMessage');
					window.location='$redirectUrl';
				</script>
			";
		}

		/**
		 * Update a record in the 'relationship' table.
		 *
		 * @param string $newRelationship The new value for 'desc_relationship'.
		 * @param string $queryRelationship The value to match in 'desc_relationship'.
		 * @param string $newState The new value for 'state'.
		 *
		 * @return void
		 */
		public function updateRecord(string $newRelationship, string $queryRelationship, string $newState)
		{
			$sql = "
				UPDATE relationship
				SET desc_relationship = UPPER(:newRelationship),
						state = :newState
				WHERE desc_relationship = :queryRelationship
			";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
					'newRelationship' => $newRelationship,
					'newState' => $newState,
					'queryRelationship' => $queryRelationship
			]);
			echo "
				<script>
					alert('Record Successfully Updated.');
					window.location='formu_view.php';
				</script>
			";
		}

		/**
		 * Deletes a record from the relationship table based on the description of the relationship.
		 *
		 * @param string $relation The description of the relationship to delete.
		 * @return void
		 */
		public function deleteRelationship(string $relation): void
		{
			$sql = "DELETE FROM relationship WHERE desc_relationship = :relation";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':relation', $relation, PDO::PARAM_STR);
			$stmt->execute();
			print "
				<script>
					alert('Registro Eliminado Exitosamente.');
					window.location='formu_view.php';
				</script>
			";
		}
	}
?>
