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
		require_once '../persistence/database/Database.php';
    require_once '../persistence/genderDAO.php';
		require_once '../utils/Message.php';
		
		class GenderService
		{
			/**
			 * Class constructor.
			 *
			 * @throws PDOException If database connection fails.
			 */
			public function __construct()
			{
					try {
              $this->gender = new genderDAO();
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
			public function register(string $gender, string $state)
			{
					try {
							if (!empty($gender)) {
									if (Message::isRegistered(Database::connect(), 'gender', 'description', $gender, false, null))
									{
											Message::showErrorMessage(
													"El género ingresado ya se encuentra registrado en la plataforma",
													'../../views/genderView.php'
											);
											return;
									}
									
                  $this->gender->register($gender, $state);
						
									Message::showSuccessMessage(
											"Registro Agregado Exitosamente.",
											'../../views/genderView.php'
									);
							} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/genderView.php'
								);
							}
					} catch (Exception $e) {
							Message::showErrorMessage(
									"Ocurrió un error interno. Consulta al Administrador.",
									'../../views/genderView.php'
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
			public function update(string $idGender, string $gender, string $state)
			{
				try {
					if (!empty($idGender) && !empty($gender)) {
						if (Message::isRegistered(Database::connect(), 'gender', 'description', $gender, true, $idGender, 'id_gender'))
						{
							Message::showErrorMessage(
								"El género ingresado ya se encuentra registrado en la plataforma",
								'../../views/genderView.php'
							);
							return;
						}
						
            $this->gender->update($idGender, $gender, $state);
            
						Message::showSuccessMessage(
							"Registro Actualizado Exitosamente.",
							'../../views/genderView.php'
						);
					} else {
						Message::showWarningMessage(
							"Debes llenar todos los campos.",
							'../../views/genderView.php'
						);
					}
				} catch (Exception $e) {
					echo $e->getMessage();
					Message::showErrorMessage(
						"Ocurrió un error interno. Consulta al Administrador.",
						'../../views/genderView.php'
					);
				}
			}
			
			/**
			 * Deletes a record from the gender table based on the given gender id.
			 *
			 * @param string $idGender The gender id to be deleted.
			 * @return void
			 */
			public function delete(string $idGender)
			{
				try {
					if (!empty($idGender)) { // Check if gender id is not empty
            $this->gender->delete($idGender);

						// Show success message after deleting the gender
						Message::showSuccessMessage(
							"Registro Eliminado Exitosamente.",
							'../../views/genderView.php'
						);
					} else {
						// Show warning message if gender id is empty
						Message::showWarningMessage(
							"Debes llenar todos los campos.",
							'../../views/genderView.php'
						);
					}
				} catch (Exception $e) {
					// Show error message if an error occurs while deleting the gender
					Message::showErrorMessage(
						"Ocurrió un error interno. Consulta al Administrador.",
						'../../views/genderView.php'
					);
				}
			}
	}
?>
</body>

</html>