<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Género</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
		class GenderDAO
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
					try {
							if (!empty($gender)) {
									$sql = "
										INSERT INTO gender(description, state)
										VALUES(UPPER(:gender), :state)
									";
									$stmt = $this->pdo->prepare($sql);
									$stmt->execute(['gender' => $gender, 'state' => $state]);
						
									$this->showSuccessMessage(
											"Registro Agregado Exitosamente.",
											'../../views/atributes/genderView.php'
									);
							} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/genderView.php'
								);
							}
					} catch (Exception $e) {
							$this->showErrorMessage(
									"Ocurrió un error interno. Consulta al Administrador.",
									'../../views/atributes/genderView.php'
							);
					}
			}

			/**
			 * Update gender information in the database.
			 *
			 * @param string $idGender The id of the gender to be updated.
			 * @param string $gender The new gender description.
			 * @param string $state The new state of the gender in the database.
			 *
			 * @return void
			 */
			public function updateGender(string $idGender, string $gender, string $state)
			{
				try {
					if (!empty($idGender) && !empty($gender)) {
						$sql = "
							UPDATE gender
							SET description = UPPER(?), state = ?
							WHERE id_gender = ?
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([$gender, $state, $idGender]);

						$this->showSuccessMessage(
							"Registro Actualizado Exitosamente.",
							'../../views/atributes/genderView.php'
						);
					} else {
						$this->showWarningMessage(
							"Debes llenar todos los campos.",
							'../../views/atributes/genderView.php'
						);
					}
				} catch (Exception $e) {
					$this->showErrorMessage(
						"Ocurrió un error interno. Consulta al Administrador.",
						'../../views/atributes/genderView.php'
					);
				}
			}
			
			/**
			 * Deletes a record from the gender table based on the given gender id.
			 *
			 * @param string $idGender The gender id to be deleted.
			 * @return void
			 */
			public function deleteGender(string $idGender)
			{
				try {
					if (!empty($idGender)) { // Check if gender id is not empty
						$sql = "
							UPDATE gender
							SET state = 3
							WHERE id_gender = ?
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->bindParam(1, $idGender);
						$stmt->execute();

						// Show success message after deleting the gender
						$this->showSuccessMessage(
							"Registro Eliminado Exitosamente.",
							'../../views/atributes/genderView.php'
						);
					} else {
						// Show warning message if gender id is empty
						$this->showWarningMessage(
							"Debes llenar todos los campos.",
							'../../views/atributes/genderView.php'
						);
					}
				} catch (Exception $e) {
					// Show error message if an error occurs while deleting the gender
					$this->showErrorMessage(
						"Ocurrió un error interno. Consulta al Administrador.",
						'../../views/atributes/genderView.php'
					);
				}
			}
		
			/**
			 * Displays a success message using SweetAlert and redirects the user to a specified location.
			 *
			 * @param string $message The success message to display
			 * @param string $redirectURL The URL to redirect to after displaying the message
			 */
			private function showSuccessMessage(string $message, string $redirectURL): void
			{
					echo "
							<script>
									Swal.fire({
											position: 'top-end',
											icon: 'success',
											title: '$message',
											showConfirmButton: false,
											timer: 2000
									}).then(() => {
											window.location = '$redirectURL';
									});
							</script>
					";
			}

			/**
			 * Displays an error message using SweetAlert and redirects the user to a specified location.
			 *
			 * @param string $message The error message to display
			 * @param string $redirectURL The URL to redirect to after displaying the message
			 */
			private function showErrorMessage(string $message, string $redirectURL): void
			{
					echo "
							<script>
									Swal.fire({
											position: 'top-center',
											icon: 'error',
											title: '$message',
											showConfirmButton: false,
											timer: 2000
									}).then(() => {
											window.location = '$redirectURL';
									});
							</script>
					";
			}

			/**
			 * Displays an warning message using SweetAlert and redirects the user to a specified location.
			 *
			 * @param string $message The error message to display
			 * @param string $redirectURL The URL to redirect to after displaying the message
			 */
			private function showWarningMessage(string $message, string $redirectURL): void
			{
					echo "
							<script>
									Swal.fire({
											position: 'top-center',
											icon: 'warning',
											title: '$message',
											showConfirmButton: false,
											timer: 2000
									}).then(() => {
											window.location = '$redirectURL';
									});
							</script>
					";
			}
	}
?>
</body>

</html>