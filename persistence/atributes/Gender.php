<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tipo de Documento</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body><?php
	class Gender
	{
		private $pdo;

		/**
		 * Class constructor.
		 *
		 * @throws PDOException If database connection fails.
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
		 * Registers a new gender in the database.
		 *
		 * @param string $gender The name of the gender to be registered.
		 * @param string $state The state where the gender is located.
		 */
		public function registerGender(string $gender, string $state)
		{
			$sql = "INSERT INTO gender(desc_gender,state) VALUES(UPPER(:gender), :state)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(['gender' => $gender, 'state' => $state]);

			echo "
				<script>
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Registro Agregado Exitosamente.',
						showConfirmButton: false,
						timer: 2000
					}).then(() => {
							window.location = '../../views/atributes/genderView.php';
					});
				</script>
			";
		}

		/**
		 * Update gender information in the database.
		 *
		 * @param string $newGender The updated gender description.
		 * @param string $oldGender The gender description to be updated.
		 * @param string $state     The state of the gender in the database.
		 *
		 * @return void
		 */
		public function updateGender(string $newGender, string $oldGender, string $state)
		{
			$sql = "
					UPDATE gender
					SET desc_gender = UPPER(?), state = ?
					WHERE desc_gender = ?
			";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$newGender, $state, $oldGender]);

			echo "
				<script>
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Registro Actualizado Exitosamente.',
						showConfirmButton: false,
						timer: 2000
					}).then(() => {
							window.location = '../../views/atributes/genderView.php';
					});
				</script>
			";
		}

		/**
		 * Delete a record from the gender table based on the given gender.
		 *
		 * @param string $gender The gender to be deleted.
		 *
		 * @return void
		 */
		public function deleteGender(string $gender)
		{
			$sql = "DELETE FROM gender WHERE desc_gender = ?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(1, $gender);
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
							window.location = '../../views/atributes/genderView.php';
					});
				</script>
			";
		}
	}
?>
</body>

</html>