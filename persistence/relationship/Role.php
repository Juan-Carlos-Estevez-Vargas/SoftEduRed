<?php
	class Role
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class.
		 *
		 * Creates a new PDO connection object using database::conectar().
		 * Throws an exception with the error message if the connection fails.
		 */
		public function __construct()
		{
			try {
				$this->pdo = database::conectar();
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage());
			}
		}

		/**
		 * Adds a new role to the database with the provided description and state
		 *
		 * @param string $description The description of the role
		 * @param string $state The state of the role
		 * @return void
		 */
		public function addRole(string $description, string $state): void
		{
			$sql = "
				INSERT INTO role (desc_role, state)
				VALUES (UPPER(:description), :state)
			";
			$statement = $this->pdo->prepare($sql);
			$statement->execute(['description' => $description, 'state' => $state]);
			echo "
				<script>
					alert('Role added successfully.');
					window.location='../views/relationship/roleView.php';
				</script>
			";
		}

		/**
		 * Updates a record in the "role" table.
		 *
		 * @param string $newDesc The new value for the "desc_role" column.
		 * @param string $oldDesc The value to match in the "desc_role" column of the record to update.
		 * @param string $newState The new value for the "state" column.
		 * @return void
		 */
		public function updateRole(string $newDesc, string $oldDesc, string $newState)
		{
			$sql = "
				UPDATE role
				SET desc_role = UPPER('$newDesc'),
						state = '$newState'
				WHERE desc_role = '$oldDesc'
			";
			$this->pdo->query($sql);
			print "
				<script>
					alert('Record Successfully Updated.');
					window.location='../views/relationship/roleView.php';
				</script>
			";
		}

		/**
		 * Deletes a record from the "role" table based on a given description.
		 *
		 * @param string $description The description of the role to be deleted
		 * @throws PDOException If there is an error executing the SQL statement
		 */
		public function deleteRole(string $description)
		{
			$sql = "DELETE FROM role WHERE desc_role = :description";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':description', $description);
			$stmt->execute();
			echo "
				<script>
					alert('Registro Eliminado Exitosamente.');
					window.location='../views/relationship/roleView.php';
				</script>
			";
		}
	}
?>
