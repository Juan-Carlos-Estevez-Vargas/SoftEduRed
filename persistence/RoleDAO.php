<?php
	require_once '../utils/Message.php';

	class RoleDAO
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
						$this->pdo = database::connect();
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
		public function register(string $description, string $state): void
		{
			try {
					$sql = "
							INSERT INTO role (description, state)
							VALUES (UPPER(:description), :state)
					";
					$statement = $this->pdo->prepare($sql);
					$statement->execute(['description' => $description, 'state' => $state]);
			} catch (Exception $e) {
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/roleView.php'
					);
			}
		}

		/**
		 * Updates a record in the "role" table.
		 *
		 * @param string $idRole  The ID of the role to update.
		 * @param string $state   The new value for the "state" column.
		 *
		 * @return void
		 */
		public function update(string $idRole, string $state)
		{
				try {
						$sql = "
								UPDATE role
								SET state = :state
								WHERE id_role = :idRole
						";
						// Prepare the SQL statement.
						$stmt = $this->pdo->prepare($sql);
						// Bind the parameters.
						$stmt->bindParam(':state', $state);
						$stmt->bindParam(':idRole', $idRole);
						// Execute the statement.
						$stmt->execute();
				} catch (Exception $e) {
						// Show error message if an exception occurs.
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleView.php'
						);
				}
		}

		/**
		 * Deletes a record from the "role" table based on a given ID.
		 *
		 * @param string $idRole The ID of the role to be deleted
		 * @throws PDOException If there is an error executing the SQL statement
		 */
		public function delete(string $idRole)
		{
				try {
						$sql = "
								UPDATE role
								SET state = 3
								WHERE id_role = :role
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->bindParam(':role', $idRole);
						$stmt->execute();
				} catch (Exception $e) {
						// Show error message if there is an exception
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleView.php'
						);
				}
		}
	}
?>