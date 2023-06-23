<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rol</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
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
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Registro Agregado Exitosamente.',
						showConfirmButton: false,
						timer: 2000
					}).then(() => {
							window.location = '../../views/relationship/roleView.php';
					});
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
			
			echo "
			<script>
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Registro Actualizado Exitosamente.',
					showConfirmButton: false,
					timer: 2000
				}).then(() => {
						window.location = '../../views/relationship/roleView.php';
				});
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
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Registro Eliminado Exitosamente.',
						showConfirmButton: false,
						timer: 2000
					}).then(() => {
							window.location = '../../views/relationship/roleView.php';
					});
				</script>
			";
		}
	}
?>
</body>

</html>