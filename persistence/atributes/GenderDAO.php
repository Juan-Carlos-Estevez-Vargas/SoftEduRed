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
									$sql = "INSERT INTO gender(desc_gender,state) VALUES(UPPER(:gender), :state)";
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
			 * @param string $newGender The updated gender description.
			 * @param string $oldGender The gender description to be updated.
			 * @param string $state     The state of the gender in the database.
			 *
			 * @return void
			 */
			public function updateGender(string $newGender, string $oldGender, string $state)
			{
				try {
						if (!empty($newGender) && !empty($oldGender)) {
								$sql = "
										UPDATE gender
										SET desc_gender = UPPER(?), state = ?
										WHERE desc_gender = ?
								";
								$sql2 = "
										UPDATE gender
										SET desc_gender = UPPER($newGender), state = $state
										WHERE desc_gender = $oldGender
								";
								echo $sql2;
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$newGender, $state, $oldGender]);

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
			 * Delete a record from the gender table based on the given gender.
			 *
			 * @param string $gender The gender to be deleted.
			 *
			 * @return void
			 */
			public function deleteGender(string $gender)
			{
					try {
							if (!empty($gender)) {
									$sql = "DELETE FROM gender WHERE desc_gender = ?";
									$stmt = $this->pdo->prepare($sql);
									$stmt->bindParam(1, $gender);
									$stmt->execute();

									$this->showSuccessMessage(
											"Registro Eliminado Exitosamente.",
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